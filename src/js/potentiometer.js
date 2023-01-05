(function(global) {

	"use strict";

	// The constructor function
	function Potentiometer(options) {
		/* We can't load more than one widget at a time because of some async issues,
		/* so we need a global flag to signify when one widget is done loading */
		if (global.loadingPotentiometer !== undefined)
			global.loadingPotentiometer = true;
		else
			global.loadingPotentiometer = false;

		var self = this;
		
		initializeWidget(self, options);
		
	}

	function initializeWidget(self, options) {
		
		/* if no other potentiometer widget is currently lading then load the widget,
		/* if a potentiometer widget is loading wait a little (10ms) and then load */
		if (global.loadingPotentiometer === false) {

			self.center = { x: 0, y: 0 }; // center of the widget, used for calculations
			self.canvas = options.canvas;

			// if the user has provided a bg image, attach it to self
			if (options.bgImgUrl !== undefined) {
				self.bgImg = new Image();
				self.bgImg.src = options.bgImgUrl;
			}

			// the entire spritesheet
			self.spritesheet = new Image();
			self.spritesheet.src = options.spritesheetUrl;

			// set bounds
			if (options.bounds !== undefined) {
				self.leftBound  = options.bounds.left  || 0;
				self.rightBound = options.bounds.right || 100;
			} else {
				self.leftBound  = 0;
				self.rightBound = 100;
			}

			// if bounds are incorrectly set throw an error
			if (self.leftBound >= self.rightBound)
				throw new Error('Left bound must be lower then the rigth bound');

			// When the spritesheet loads...
			self.spritesheet.onload = function() {
				setUpCanvas(self);
				setUpContext(self);
				countSprites(self);

				/**
				*	Ok, so why is this 10ms timeout here? Here's the explanation:
				*	In the setUpCanvas() function above we change each canvas' width and height.
				*   Then we get to the getCenter() function with gets the center coordinates of our canvas elements.
				*
				*	The problem begins when we have many canvas elements, which when are put on a page like this: '<canvas id="widget1"></canvas>',
				*	with no width and height attributes (which is a legit canvas to use this widget on). 
				*   In that case they take their default width and height on the page (300x150 on Chrome). 
				*
				*   We don't have a problem with height, since no matter how much the height of the element is changed, it's offsetTop attribute will stay the same.
				*	We have a problem with width because widgets load in random order!
				*
				*	Here's how the problem occurs:
				*	Let's say we have 3 canvas elements and we instantiate this widget on all 3 of them. Canvases are all next to each other (left to right),
				*	and have no space between them and are going to be set to the same width when instantiated. Their widths by default (in Chrome) are 300px. 
				*	In total, they all take 900px of horizontal space before instantiation.
				*
				*	Now we instantiate the potentiometer widgets.
				*	Widget 1 (on canvas1) instantiates normally. It's canvas' width and height are adjusted accordingly (let's say to 50x50 px) and everything's fine.
				*	Widget 3 (on canvas3) begins to load. It calculates it's center based on it's canvas' location on the page.
				*	canvas3 has the offsetLeft property of 350 (canvas1.width + canvas2.width = 50 + 300). But when the Widget 2 loads after this that offset value won't be correct.
				* 	It should be 100px after all 3 widgets load (canvas1.width + canvas2.width = 50 + 50), which isn't the case.
				*
				*	This timeout here ensures that all of our widgets on the page have their widths properly adjusted before calculating centers of each one of them.
				*
				*	(this is probably the longest comment I've ever written in my life so far :) )
				*/
				setTimeout(function() {

					getCenter(self);
					
					// Position (the potentiometer value) = integers from 0 to 100
					self.position = 50;
					// Last position is used to make the knob not jump from 0 to 100 and vice-versa
					self.lastPosition = self.position;

					drawKnob(self);

					// Draw the background image if it exists
					if (self.bgImg !== undefined) 
						drawBgImg(self);

					// see if the user wants to control the knobs by rotation
					var verticalDrag = options.verticalDrag      || false;
					var sens   = options.sensitivity || 3;
					setUpListeners(self, verticalDrag, sens);

					// Recalculate centers when window resizes
					global.addEventListener('resize', function() {
						getCenter(self);
					});

					addInterfaceMethods(self);

					// We've finished loading the widget, let others know that they can load
					global.loadingPotentiometer = false;

				}, 10);

			};

		} else {
			setTimeout(function() {
				initializeWidget(self, options);
			}, 10);
		}

	}

	function setUpCanvas(self) {
		/* Canvas dimensions are x * x
		*
		*  If we have a bgImg, size the canvas according to
		*  it's size, if not use the spritesheet width 
		*/
		if (self.bgImg !== undefined) {
			self.canvas.height = self.bgImg.height;
			self.canvas.width  = self.bgImg.width;
			self.xOffset = ((self.canvas.width  - self.spritesheet.width) / 2);
			self.yOffset = ((self.canvas.height - self.spritesheet.width) / 2);
		} else {
			self.canvas.height = self.spritesheet.width;
			self.canvas.width  = self.spritesheet.width;
		}
	}

	// Sets up canvas context on which we will draw on
	function setUpContext(self) {
		self.context = self.canvas.getContext('2d');
	}

	function countSprites(self) {
	 	self.numberOfSprites = self.spritesheet.height / self.spritesheet.width;

	 	// If we have an odd number of sprites, just cut out the last one (so we don't have black space at the end) 
		if (self.numberOfSprites % 2 !== 0)
			self.numberOfSprites -= 1;
	}

	function getCenter(self) {
		self.center.x = self.canvas.offsetLeft + (self.canvas.width / 2);
		self.center.y = self.canvas.offsetTop  + (self.canvas.height / 2);
	}

	function drawKnob(self, isMouseEvent) {
		var percent = self.position;
		// Don't allow values less than 0 and greater than 100 (or whatever the bounds the user has provided)
		if (percent < self.leftBound)
			percent = self.leftBound;
		else if (percent > self.rightBound)
			percent = self.rightBound;

		percent = percent / 100;

		var yPos = getYPos(percent, self);

		// Limit the position property
		self.position = ~~(( ~~((percent * 100) - self.leftBound) / (self.rightBound - self.leftBound) ) * 100);

		// Don't allow big jumps in knob values when manipulating the knob with a mouse
		if (isMouseEvent) {

			if (self.lastPosition - self.position < 50 && self.lastPosition - self.position > -50)
				drawOnCanvas(self, yPos);
			else
				self.position = self.lastPosition;

		} else {
			drawOnCanvas(self, yPos);
		}

	}

	function drawOnCanvas(self, yPos) {
		var context = self.context;
		context.clearRect(0, 0, self.canvas.width, self.canvas.height);

		/* If there's a background image specified draw it after the knob, if not just draw the knob */
		if (self.bgImg !== undefined) {
			var knobWidth = self.spritesheet.width;
			// yPos' sign needs to be inverted for this to work... what a bunch of BS from the canvas API..
			yPos = -yPos;
			context.drawImage(self.spritesheet, 0, yPos, knobWidth, knobWidth, self.xOffset, self.yOffset, knobWidth, knobWidth);
			drawBgImg(self);
		} else {
			context.drawImage(self.spritesheet, 0, yPos);
		}

		self.lastPosition = self.position;
	}

	function drawBgImg(self) {
		var context = self.context;
		context.drawImage(self.bgImg, 0, 0);
	}

	// Calculates the spritesheet y offset value
	function getYPos(percent, self) {

		var yPos = - (~~(percent * self.numberOfSprites) * self.spritesheet.width);

		// Check the left bound
		if (yPos > - ~~((self.leftBound / 100) * self.numberOfSprites) * self.spritesheet.width)
			yPos = - ~~((self.leftBound / 100) * self.numberOfSprites) * self.spritesheet.width;
		// Check the right
		else if (yPos < - ~~((self.rightBound / 100) * self.numberOfSprites) * self.spritesheet.width)
			yPos = - ~~((self.rightBound / 100) * self.numberOfSprites) * self.spritesheet.width;

		return yPos;
	}

	function setUpListeners(self, verticalDrag, sensitivity) {

		if (verticalDrag === true)				// if we want to control the knobs by vertical mouse dragging
			setUpVerticalDragListeners(self, sensitivity);
		else {									// if we want to control the knobs by rotation
			setUpRotationListeners(self);
		}

		setUpDoubleClick(self);

	}

	function triggerEvent(self, eventName) {
		// create a custom event
		var widgetEvent = document.createEvent('Event');

		// define that the event name is
		widgetEvent.initEvent(eventName, true, true);

		// make the pot value available to the listener
		widgetEvent.srcValue = self.position;

		// make the canvas that triggered the event available to the listener
		widgetEvent.srcId = self.canvas.id;

		// dispatch the event
		self.canvas.dispatchEvent(widgetEvent);
	}

	function setUpRotationListeners(self) {
		self.isMouseDown = false;
		var xDist, yDist, totalDist, arc;
		var thisContext = self.context; // Context of the canvas that's been clicked on

		self.canvas.onmousedown = function(event) {
			xDist =  (event.pageX - self.center.x);
			yDist = -(event.pageY - self.center.y);
			totalDist = Math.sqrt(xDist * xDist + yDist * yDist);

			if (totalDist > (self.spritesheet.width / 2))
				self.isMouseDown = false;
			else {
				self.isMouseDown = true;
				updateKnob(self, event);
			}

			document.onmouseup   = function(event) { self.isMouseDown = false; };

			document.onmousemove = function(event) {
				updateKnob(self, event);
			};
		};

		function updateKnob(self, event) {
			if (self.isMouseDown) {

				xDist =  (event.pageX - self.center.x);
				yDist = -(event.pageY - self.center.y);

				arc = (Math.atan2(xDist, yDist) / Math.PI) / 2;

				// Set the position property
				self.position = ~~(101 * (arc) + 50);
				drawKnob(self, true);

				triggerEvent(self, 'potValueChanged');
			}
		}
	}

	/**
	*	@param {number} sensitivity - Integer value that sets fast does 
	*   							  the value change when we drag the mouse (smaller number = faster).
	*/
	function setUpVerticalDragListeners(self, sensitivity) {
		self.isMouseDown = false;

		self.canvas.onmousedown = function(event) {
			var currentY = 0;
			var lastY    = event.clientY;
			var deltaY   = 0;
			var ctrlMod  = 1;
			
			self.isMouseDown = true;

			document.onmouseup   = function(event) { 
				self.isMouseDown = false;
				deltaY = 0;
			};

			document.onmousemove = function(event) {

				if (self.isMouseDown) {

					// If the ctrl button is down, make fine adjustments to the value
					if (event.ctrlKey)
						ctrlMod = 4;
					else
						ctrlMod = 1;

					currentY = event.clientY;
					deltaY += (lastY - currentY) / (sensitivity * ctrlMod);

					if (deltaY > 1 || deltaY <= -1) {

						deltaY = ~~deltaY; // cast to int
						updateKnob(self, deltaY);
						deltaY = 0;

					}

					lastY = currentY;

				}

			};

			function updateKnob(self, deltaY) {
				if (self.isMouseDown) {

					// Set the position property
					self.position += deltaY;

					// Prevent position overshoot/undershoot
					if      (self.position > 100) self.position = 100;
					else if (self.position < 0)   self.position =   0;

					// Calculate bounds for drawing
					var position = (self.position / 100) * (self.rightBound - self.leftBound) + self.leftBound;

					var yPos = getYPos(position / 100, self);

					// Draw the widget
					drawOnCanvas(self, yPos);

					console.log(position);
					console.log('self.position: ' + self.position);

					triggerEvent(self, 'potValueChanged');
				}
			}

		};

	}

	// Double click setup
	function setUpDoubleClick(self) {
		self.canvas.addEventListener('dblclick', function(event) {
			var xDist =  (event.pageX - self.center.x);
			var yDist = -(event.pageY - self.center.y);
			var totalDist = Math.sqrt(xDist * xDist + yDist * yDist);

			if (totalDist < (self.spritesheet.width / 2))
				triggerEvent(self, 'potDoubleClick');

		});
	}

	/* --------------- Interface methods --------------- */

	function addInterfaceMethods(self) {

		self.getValue = function() {
			return self.position;
		};

		self.setValue = function(position) {

			// Prevent position overshoot/undershoot
			if      (position > 100) position = 100;
			else if (position < 0)   position =   0;

			self.position = ~~position;

			// Take bounds into account
			var boundsPercent = (self.rightBound - self.leftBound) / 100;

			position = self.leftBound + (position * boundsPercent);
 
			var yPos = getYPos(position / 100, self);

			// Draw the widget
			drawOnCanvas(self, yPos);
		};

	}

	/* ------------------------------------------------- */

	// Make the constructor available in the global scope
	global.Potentiometer = Potentiometer;

})(window);
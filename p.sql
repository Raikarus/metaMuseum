--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: gkwords; Type: TABLE; Schema: public; Owner: sch; Tablespace: 
--

CREATE TABLE gkwords (
    gkword_id integer NOT NULL,
    gkword_name character varying(128) NOT NULL
);


ALTER TABLE public.gkwords OWNER TO sch;

--
-- Name: kwords; Type: TABLE; Schema: public; Owner: sch; Tablespace: 
--

CREATE TABLE kwords (
    tag_id integer,
    tag_id_num integer,
    kword_name character varying(256) NOT NULL,
    gkword_id integer DEFAULT 0,
    hidden integer DEFAULT 0
);


ALTER TABLE public.kwords OWNER TO sch;

--
-- Name: locktable; Type: TABLE; Schema: public; Owner: sch; Tablespace: 
--

CREATE TABLE locktable (
    lockfield integer
);


ALTER TABLE public.locktable OWNER TO sch;

--
-- Name: pics; Type: TABLE; Schema: public; Owner: sch; Tablespace: 
--

CREATE TABLE pics (
    pic_id bigint NOT NULL,
    fmt character varying(4),
    subscr text,
    title text,
    width integer,
    height integer,
    date timestamp without time zone,
    dirnum bigint,
    fsize bigint,
    md5 character varying(32),
    rights text,
    vol_id integer,
    jpg_id bigint DEFAULT 0
);


ALTER TABLE public.pics OWNER TO sch;

--
-- Name: pictags; Type: TABLE; Schema: public; Owner: sch; Tablespace: 
--

CREATE TABLE pictags (
    pic_id bigint NOT NULL,
    tag_id integer NOT NULL,
    tag_id_num integer NOT NULL,
    doubt integer DEFAULT 0
);


ALTER TABLE public.pictags OWNER TO sch;

--
-- Name: tags; Type: TABLE; Schema: public; Owner: sch; Tablespace: 
--

CREATE TABLE tags (
    tag_id integer NOT NULL,
    tag_prt integer NOT NULL,
    tag_path character varying(256) NOT NULL,
    tag_name character varying(30),
    pics_name character varying(10),
    tag_type integer
);


ALTER TABLE public.tags OWNER TO sch;

--
-- Name: volumes; Type: TABLE; Schema: public; Owner: sch; Tablespace: 
--

CREATE TABLE volumes (
    vol_id integer NOT NULL,
    dirname text,
    lock integer DEFAULT 0
);


ALTER TABLE public.volumes OWNER TO sch;

--
-- Data for Name: gkwords; Type: TABLE DATA; Schema: public; Owner: sch
--

COPY gkwords (gkword_id, gkword_name) FROM stdin;
1	Персоналии
2	Организации
3	События
0	
\.


--
-- Data for Name: kwords; Type: TABLE DATA; Schema: public; Owner: sch
--

COPY kwords (tag_id, tag_id_num, kword_name, gkword_id, hidden) FROM stdin;
0	0		0	0
10	1	Военные песни 1930-х гг	0	0
10	2	Vol1	0	0
10	3	IMGP1464	0	0
10	4	206-207 IMGP1467	0	0
10	5	204-205 IMGP1490	0	0
10	6	IMGP1486	0	0
10	7	203 IMGP1488	0	0
10	8	Пионерская правда	0	0
10	9	N001(583)	0	0
10	10	1931	0	0
10	11	P1140009	0	0
10	12	JPG	0	0
10	13	P1140008	0	0
10	14	P1140010	0	0
10	15	P1140011	0	0
10	16	P1140012	0	0
10	17	P1130832	0	0
10	18	P1130835	0	0
10	19	P1130834	0	0
10	20	P1130833	0	0
10	21	P1130831	0	0
10	22	Ансамбль в Артеке	0	0
10	23	анс в артеке	0	0
10	24	анс в артеке-1	0	0
10	25	Artek-1975	0	0
10	26	Artek-1975-001-1	0	0
10	27	Artek-1975-001	0	0
10	28	Вожатый. - 1936 – №10 - С.36 	0	0
10	29	К хронике 1936 года	0	0
10	30	Вожатый. - 1936. - №8 - с.13 P0475	0	0
10	31	Пионеры-герои	0	0
10	32	Лида Вашкевич_PG-037	0	0
10	33	Марат Казей_PG-047	0	0
10	34	Валя Котик_PG-048	0	0
10	35	Зина Портнова_PG-045	0	0
10	36	Боря Кулешин_PG-021	0	0
10	37	Володя Колядов_PG-008	0	0
10	38	Толя Шумов_PG-017	0	0
10	39	Нина Куковерова_ PG-002	0	0
10	40	Валя Зенкина_PG-033	0	0
10	41	Володя Дубинин_PG-004	0	0
10	42	Муся Пинкельзон_PG-039	0	0
10	43	Володя Казначеев_PG-027	0	0
10	44	Витя Хоменко_PG-022	0	0
10	45	Костя Кравчук_PG-044	0	0
10	46	Лара Михеенко_PG-005	0	0
10	47	Сергей Алешков_PG-051	0	0
10	48	Ваня Андрианов_PG-041	0	0
10	49	Шура Кобер_PG-023	0	0
10	50	Леня Голиков_PG-046	0	0
10	51	Витя Коробков_PG-003	0	0
10	52	Вера Иванова_PG-050	0	0
10	53	Аркаша Каманин_PG-032	0	0
10	54	Надя Богданова_PG-043	0	0
10	55	Саша Ковалев_PG-018	0	0
10	56	Artek-Galadg-002	0	0
10	57	Artek-Galadg	0	0
10	58	Artek-Galadg-002-1	0	0
10	59	Artek-003	0	0
10	60	Документы	0	0
10	61	Vol2	0	0
10	62	Artek-004	0	0
10	63	Artek-001	0	0
10	64	Artek-002	0	0
10	65	Берлин - стекло	0	0
10	66	интерьеры	0	0
10	67	Artek-steklo-neg-Kor10-S002	0	0
10	68	строения	0	0
10	69	Artek-steklo-neg-Kor10-S009-2-ph-kop	0	0
10	70	Artek-steklo-neg-Kor03-S009	0	0
10	71	Artek-steklo-neg-Kor10-S009-1-ph-kop	0	0
10	72	Artek-steklo-neg-Kor10-S008-1-ph-kop	0	0
10	73	столовая	0	0
10	74	Artek-steklo-neg-Kor01-S011	0	0
10	75	Artek-steklo-neg-Kor10-S006-2-ph-kop	0	0
10	76	Artek-steklo-neg-Kor03-S005	0	0
10	77	марш	0	0
10	78	Artek-steklo-neg-Kor03-S006	0	0
10	79	Artek-steklo-neg-BF-Kor01-S006	0	0
10	80	общий вид	0	0
10	81	Artek-steklo-neg-BF-Kor01-S001	0	0
10	82	Artek-steklo-neg-Kor25-S009	0	0
10	83	беседка	0	0
10	84	Artek-steklo-neg-Kor09-S005-Solov'evy	0	0
10	85	Artek-steklo-neg-Kor25-S010	0	0
10	86	Artek-steklo-neg-Kor09-S004-Solov'evy	0	0
10	87	Artek-steklo-neg-BF-Kor01-S002-1-ph-kop	0	0
10	88	умывальник	0	0
10	89	Artek-steklo-neg-BF-Kor01-S002-2-ph-kop	0	0
10	90	план корпуса	0	0
10	91	Artek-steklo-neg-Kor04-S008	0	0
10	92	занятия детей	0	0
10	93	Artek-steklo-neg-Kor03-S003	0	0
10	94	Artek-steklo-neg-Kor14-S002	0	0
10	95	Artek-steklo-neg-Kor10-S015-ph-kop	0	0
10	96	Artek-steklo-neg-Kor04-S013	0	0
10	97	сотрудники	0	0
10	98	Artek-steklo-neg-Kor12-S003	0	0
10	99	Artek-steklo-neg-Kor03-S004	0	0
10	100	море	0	0
10	101	Artek-steklo-neg-Kor34-S011	0	0
10	102	Artek-steklo-neg-Kor11-S001	0	0
10	103	Artek-steklo-neg-Kor03-S018	0	0
10	104	Artek-steklo-neg-Kor04-S007	0	0
10	105	автомобиль	0	0
10	106	линейка, площадка	0	0
10	107	Artek-steklo-neg-Kor04-S003	0	0
10	108	Artek-steklo-neg-Kor02-S002	0	0
10	109	Artek-steklo-neg-Kor03-S016	0	0
10	110	Artek-steklo-neg-Kor10-S003	0	0
10	111	ворота	0	0
10	112	Artek-steklo-neg-Kor35-S005	0	0
10	113	физкультура	0	0
10	114	Artek-steklo-neg-Kor03-S007	0	0
10	115	Artek-steklo-neg-Kor03-S010	0	0
10	116	Artek-steklo-neg-Kor02-S005	0	0
10	117	построение, оркестр	0	0
10	118	игры, танцы	0	0
10	119	Artek-steklo-neg-Kor04-S005-(ph-kop)	0	0
10	120	Artek-steklo-neg-BF-Kor01-S005	0	0
10	121	1980. Отчетный концерт Ансамбля имени Локтева (Хор Пионер, хорм. Егорова А.А., Хор Колокольчик, хорм. Жукова З.И.)	0	0
10	122	MGDPiCh-1980-05-25-neg-005	0	0
10	123	MGDPiCh-1980-05-25-neg-002	0	0
10	124	MGDPiCh-1980-05-25-neg-010	0	0
10	125	MGDPiCh-1980-05-25-neg-011	0	0
10	126	MGDPiCh-1980-05-25-neg-009	0	0
10	127	MGDPiCh-1980-05-25-neg-001	0	0
10	128	MGDPiCh-1980-05-25-neg-006	0	0
10	129	MGDPiCh-1980-05-25-neg-007	0	0
10	130	MGDPiCh-1980-05-25-neg-008	0	0
10	131	MGDPiCh-1980-05-25-neg-004	0	0
10	132	MGDPiCh-1980-05-25-neg-003	0	0
10	133	Artek-1926-001	0	0
10	134	TIF	0	0
10	135	Artek-1926-002	0	0
10	136	Artek-1926-004	0	0
10	137	Artek-1926-003	0	0
10	138	Vol4	0	0
\.


--
-- Data for Name: locktable; Type: TABLE DATA; Schema: public; Owner: sch
--

COPY locktable (lockfield) FROM stdin;
0
\.


--
-- Data for Name: pics; Type: TABLE DATA; Schema: public; Owner: sch
--

COPY pics (pic_id, fmt, subscr, title, width, height, date, dirnum, fsize, md5, rights, vol_id, jpg_id) FROM stdin;
0	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	0
126	jpg			710	1000	2015-05-31 16:27:26	\N	163923	98366b26f94d34330a57bf22fbd9dbfa		26	0
1	jpg	Очень-очень длинное "описание содержания" картинки	Короткий заголовок картинки	3648	2736	2008-07-24 11:26:43	\N	1946158	476b7571d224591de1488a659cfd6539		1	0
2	jpg			3648	2736	2008-07-24 11:27:06	\N	1775148	0e50e8046b58e18a3cec6f50d160582a		1	0
3	jpg			3648	2736	2008-07-25 11:08:34	\N	1874920	7493385515648067b5e3d7a601801e95		1	0
4	jpg			3648	2736	2008-07-25 11:07:42	\N	1958555	a970c3b6572b4b3181057696d9f6c382		1	0
5	jpg			3648	2736	2008-07-25 11:08:16	\N	1947106	ee97fd9dc816c50621fdf6c16cc4aeeb		1	0
6	jpg			2448	3264	2016-02-27 17:20:38	\N	1931196	68c4f30e25779c50d924833bc6281a81		1	0
7	raw			2448	3264	2016-02-27 17:20:38	\N	13687808	8eb581f8812f9121c37edff2752cd029		1	6
8	jpg			2448	3264	2016-02-27 17:20:21	\N	1954639	afb6a497b12b2fe1d0d5952d6cf810a0		1	0
9	raw			2448	3264	2016-02-27 17:20:21	\N	13691392	60ced054a584df8bfdac1992df4565c6		1	8
10	jpg			2448	3264	2016-02-27 17:20:55	\N	1979359	ac0c4485c576b9eeec72dc6d61acc3e2		1	0
11	raw			2448	3264	2016-02-27 17:20:55	\N	13688320	61c9dadcb8819c0bfeb1983a25bf646a		2	10
12	jpg			2448	3264	2016-02-27 17:21:20	\N	1959099	cf128bddbcf2dce0be27234ef8e4da70		1	0
13	raw			2448	3264	2016-02-27 17:21:20	\N	13689344	2b2a07386717b793c5b46208f4ca9e12		2	12
14	jpg			2448	3264	2016-02-27 17:22:15	\N	1766736	a2ad8e8368be00536e5dbde2388660d8		1	0
15	raw			2448	3264	2016-02-27 17:22:15	\N	13731840	38a635967cff14404b30369292f3e48a		2	14
16	jpg			2448	3264	2016-02-27 16:08:40	\N	1515379	5999c583c2940eeeea7cdd364bb6384b		1	0
17	raw			2448	3264	2016-02-27 16:08:40	\N	13769216	d5a6e988ecb479d00eb38007d73f4a04		3	16
18	jpg			2448	3264	2016-02-27 16:10:15	\N	1952632	4132c882fcea02c0a09df17b1eb181e4		1	0
19	raw			2448	3264	2016-02-27 16:10:15	\N	13689856	d27463a36f654d4a716e3a0c917eaeea		3	18
20	jpg			2448	3264	2016-02-27 16:10:02	\N	2031976	b9d57dd4c710e9cd7ed27fb2bbdff839		2	0
21	raw			2448	3264	2016-02-27 16:10:02	\N	13684736	7d9d45fb54096bce07c47ba863a40db8		3	20
22	jpg			2448	3264	2016-02-27 16:09:43	\N	2031939	85e72c9b5067de5d588be97d7d085e3e		2	0
23	raw			2448	3264	2016-02-27 16:09:43	\N	13665792	00f2ca88a248f5ba6b06bde658768899		4	22
24	jpg			2448	3264	2016-02-27 16:07:45	\N	1809763	7b24f8cd7f232838cee9172bd671b3b1		2	0
25	raw			2448	3264	2016-02-27 16:07:45	\N	13730816	7a6a3632c4a15df3d9fe9b4ac0ece1cb		4	24
26	jpg			1359	855	2007-09-06 10:03:28	\N	292291	d4b9518e215dff9727facd4ea693ac07		2	0
27	jpg			1359	855	2015-05-18 18:30:04	\N	312925	2da876865d97f00dd27726f3c84ff26b		2	0
28	jpg			2362	1663	2015-05-18 18:23:20	\N	462332	bc34e3e480ff94df8d52b4ea5b49486f		2	0
29	jpg			6790	4780	2010-09-09 15:45:36	\N	2669713	e2f909e3d37fc6ae0e3643ed1bf82193		3	0
30	jpg			3648	2736	2008-02-06 16:03:28	\N	1951618	caf6aef1ca54e4db8971fdb8c8200252		3	0
31	jpg			3648	2736	2008-02-06 15:56:15	\N	1897293	6eed3a572cd32a188f16b63579ff6f79		2	0
32	jpg			4834	6163	2014-03-05 19:21:12	\N	6490498	9a00fcc087bc5b97607109c195a03b71		4	0
33	jpg			4515	5815	2014-03-05 19:56:11	\N	6074988	7f87f2eaa6aceab884ef34e6cb0ba397		4	0
34	jpg			4515	5815	2014-03-05 19:56:12	\N	5828290	b179726f8a25631d58edf8eb85bcda05		4	0
35	jpg			4515	5815	2014-03-05 19:56:08	\N	6041907	555fa139218a7acdc3a09d8bb065f9c3		5	0
36	jpg			4834	6163	2014-03-05 16:18:15	\N	7813985	a3bf1b6dacd67f817d7cdaace1942e5b		5	0
37	jpg			4834	6163	2014-03-05 15:54:10	\N	7853766	40fd46b3706fe663a720584f1160163a		5	0
38	jpg			4834	6163	2014-03-05 15:54:40	\N	6076376	683c0f8801a73394c8650983b66a7df8		5	0
39	jpg			4834	6163	2014-03-05 15:53:54	\N	6498873	4eb89a5f2ff8bcee5657cad04ed58057		5	0
40	jpg			4834	6163	2014-03-05 19:20:58	\N	7238644	30a931ccfad4ce3c1e33175876001d09		5	0
41	jpg			4834	6163	2014-03-05 15:53:58	\N	6296724	f2008a08f9903f2a1993072b55e70ab7		5	0
42	jpg			4834	6163	2014-03-05 19:21:19	\N	6814027	899f396727e78c703f36b9b60687679f		6	0
43	jpg			4834	6163	2014-03-05 16:18:26	\N	8818273	104b759fa89884ecc40f986a21b40ffd		6	0
44	jpg			4834	6163	2014-03-05 16:18:17	\N	8260985	2ac03d678500cb3a6d74189f6f11eb52		6	0
45	jpg			4834	6163	2014-03-05 19:21:37	\N	6464107	6ee8a7958508cea04eab67637677d692		6	0
46	jpg			4834	6163	2014-03-05 15:53:59	\N	6225491	5b2b0ebaf976d637da1cdc9a44caa685		6	0
47	jpg	CREATOR: gd-jpeg v1.0 (using IJG JPEG v62), quality = 90		600	799	2014-03-20 16:11:43	\N	120025	13982574e274a51c894178ef2a076340		3	0
48	jpg			4834	6163	2014-03-05 19:21:26	\N	7662600	b48ac43af3f2b5a601b9423bb106b50d		6	0
49	jpg			4834	6163	2014-03-05 16:18:19	\N	9085666	d710a03e07a59e5cb502459c17735771		7	0
50	jpg			4515	5815	2014-03-05 19:56:09	\N	6368168	0c224820b1824bb736fc958554e094df		7	0
51	jpg			4834	6163	2014-03-05 15:53:56	\N	7196322	15c4e919d0c314d0682d30719c4fdc5d		7	0
52	jpg			7600	11421	2014-03-19 20:08:05	\N	7541543	f4825b76af011f1ae1a59b00218f67ec		7	0
53	jpg			4834	6163	2014-03-05 19:20:55	\N	7135795	a6e400565897d7fdf5c6496c74d1fd96		7	0
54	jpg			4834	6163	2014-03-05 19:21:33	\N	7717939	adc2537a3c2ebbef1ae389b67b125e58		7	0
55	jpg			4834	6163	2014-03-05 15:54:44	\N	6822299	7051aa14f9b69053b174e7bca19dd730		8	0
56	jpg			8627	5549	2012-07-02 11:22:23	\N	3497507	fa6f51f548e52ca27856efec22dff6cf		3	0
57	jpg			2362	1519	2015-05-18 18:27:48	\N	495167	e3c70c717c80a7bf7475b1e5af744674		3	0
58	jpg			3272	4625	2010-11-02 14:19:22	\N	2910731	42219199a28da254af3f1f516e6fd168		9	0
59	jpg			3272	4625	2010-11-02 14:25:02	\N	2596791	a0273f7d503d9702d223b8ac3a3002ee		9	0
60	jpg			3272	4625	2010-11-02 14:16:20	\N	2841480	6404140f8e73608acc091cc12195fd10		9	0
61	jpg			3272	4625	2010-11-02 14:18:06	\N	2934025	4a9400b05df09568c8cf0886a9c251aa		9	0
62	jpg			702	1000	2015-05-31 14:36:10	\N	147436	8bbbe921b4b65fb37ae123b95ac20b40		9	0
63	jpg			1000	734	2015-05-31 14:37:39	\N	174476	1053ed8fa30e4c46f087294ee81f9fce		9	0
64	jpg			8220	4966	2015-05-31 21:40:36	\N	686068	8e6964bc37ba704205410fe71243651f		9	0
65	jpg			1000	769	2015-05-31 14:37:57	\N	159262	a4692a46f35703884c3b5df167225951		9	0
66	jpg			8765	5925	2015-05-31 22:15:26	\N	606817	f1b098316997cb0e0ebbecf00c6c21fa		9	0
67	jpg			8187	5526	2015-05-31 21:29:58	\N	1143239	947400b7f45e949acd409bc3716d7f73		9	0
68	jpg			9391	5925	2015-05-31 22:14:36	\N	910376	b39ac0c9df223eaff6f98a5907050ef0		9	0
69	jpg			8417	5986	2015-05-31 21:35:58	\N	1010671	36faa18401d5e1dc810e740a2d3cda5b		9	0
70	jpg			8187	5032	2015-05-31 21:37:00	\N	1007778	0bcf42e256d870bed46beae0250c4303		9	0
71	jpg			1000	587	2015-05-31 16:25:01	\N	173800	5106519ae20d749721006bb583bd9955		9	0
72	jpg			736	1000	2015-05-31 16:27:40	\N	178694	3005397c50d5fda6254ac220bdef31c9		9	0
73	jpg			630	1000	2015-05-31 16:27:28	\N	205816	eb122398501b8276b91a1ba3f1e58b29		9	0
74	jpg			1000	601	2015-05-31 16:27:28	\N	204892	cfe8c9ecf075e774f6b7dce1404a8d4b		9	0
75	jpg			596	1000	2015-05-31 16:27:26	\N	167173	14d9fec01fad231f6598d31e5c2f2830		9	0
76	jpg			710	1000	2015-05-31 16:27:26	\N	163923	98366b26f94d34330a57bf22fbd9dbfa		9	0
77	jpg			1000	592	2015-05-31 16:27:40	\N	159169	50dc2f47d870eff1de5fc67c4d9b949d		9	0
78	jpg			1000	729	2015-05-31 16:27:40	\N	193362	a937b9d7efb1636cdf653d679c164b2c		9	0
79	jpg			8417	5887	2015-05-31 21:50:33	\N	1450360	22e5fcb228e2f979b735581fe60d1d39		9	0
80	jpg			7891	4999	2015-05-31 21:33:50	\N	1025864	5a682c7b1f2674c69177b26651e00d2b		9	0
81	jpg			1000	701	2015-05-31 16:27:28	\N	202181	946bdf13ec550b3bde790de31a14d66e		9	0
82	jpg			9356	7012	2015-05-31 22:34:18	\N	813731	eb3d154af32ed453d91ad7cf2a9909c9		9	0
83	jpg			5920	8253	2015-05-31 21:52:38	\N	1004890	e6e141ec0890ee724f3f827b495f8846		9	0
84	jpg			1000	695	2015-05-31 16:27:26	\N	196564	8d6dc272e25e9e91462b1e246ead1e60		9	0
85	jpg			5986	8187	2015-05-31 21:34:53	\N	934863	05570ebd2fd1152575709a7aded95345		9	0
86	jpg			624	1000	2015-05-31 15:00:06	\N	204707	b4018cef803f7c2e0fdb5d03f9eecf59		9	0
87	jpg			1000	614	2015-05-31 16:27:26	\N	165904	0b9dc00335193488ad5e2604f8fe54ce		9	0
88	jpg			8187	5920	2015-05-31 21:44:13	\N	922517	68bc6ee73dc2772c26c36094b445f52e		9	0
89	jpg			8351	6052	2015-05-31 21:49:38	\N	1031774	9e93dd3c4610021c36918bc17215932a		9	0
90	jpg			8187	5131	2015-05-31 21:46:37	\N	853998	5e1295ce09f2d9d9ddf52760bf6bdd78		9	0
91	jpg			5098	8286	2015-05-31 21:31:34	\N	1364743	598e8b49f25aa2558db542872bd27b66		9	0
92	jpg			8483	5822	2015-05-31 21:43:05	\N	901055	bb4f26c695d5c4f02912478fa6b6c202		9	0
93	jpg			702	1000	2015-05-31 16:27:28	\N	202634	d0bbdf242fc5d7d45284ea68c66e86fa		9	0
94	jpg			1000	624	2015-05-31 14:44:35	\N	247921	459f70f893f161f3784a3cc1e1532d8d		9	0
95	jpg			8088	4999	2015-05-31 21:39:09	\N	983667	0411ed603011122ae46a65830f5b3ab4		9	0
96	jpg			8286	5065	2015-05-31 21:41:32	\N	765933	e903edc0acb03e522bf4b8572a8c4bfa		9	0
97	jpg			8220	6118	2015-05-31 21:32:42	\N	972644	69ecf19567854bcaf83b93ac5ff5f589		9	0
98	jpg			8351	6019	2015-05-31 21:47:41	\N	799870	52ce23e0c6321e2fd81c398f5bf182f9		9	0
99	jpg			1000	592	2015-05-31 16:24:28	\N	161345	a361142dd770e3eec25bb6b233ea555a		9	0
100	jpg			6645	6549	2016-08-11 18:03:43	\N	2908512	4f74a01e73e6a191098b8b878e3d7bdc		9	0
101	tif			6645	6549	2016-08-11 18:03:43	\N	261117590	7e62fefdbba6212d679a583bee491510		10	100
102	jpg			6645	6752	2016-08-11 18:03:28	\N	2934258	ab04632c60a393e538f503a332b0d4c3		9	0
103	tif			6645	6752	2016-08-11 18:03:28	\N	269211200	a3fb62d5c99a329a18d342e6a7784459		11	102
104	jpg			6645	6730	2016-08-11 18:04:09	\N	2922211	ba3853740f983c6dd1b6e7583f3209bd		9	0
105	tif			6645	6730	2016-08-11 18:04:09	\N	268334060	100c3ce615818b298c9582ddf436e629		12	104
106	jpg			6645	6773	2016-08-11 18:04:15	\N	3244852	11b7a66c96fe1abfa0f34e4d895dbffe		9	0
107	tif			6645	6773	2016-08-11 18:04:15	\N	270048470	d29d62dab3ff08da2667080c4556c9c0		13	106
108	jpg			6645	6752	2016-08-11 18:04:04	\N	3392184	537805fabbee8307e1c20dbbd06cc78d		9	0
109	tif			6645	6752	2016-08-11 18:04:04	\N	269211200	a036e8f42989c78e912b2a85f6d1b99d		14	108
110	jpg			6645	6741	2016-08-11 18:03:23	\N	2940197	1129f619b1240bbddf2afcdb3029afa8		15	0
111	tif			6645	6741	2016-08-11 18:03:23	\N	268772630	59dc8b0f632ff172fef29d442fa480d6		16	110
112	jpg			6645	6741	2016-08-11 18:03:49	\N	3100980	b0aaa079d8c93f0d7ddf380045c92894		15	0
113	tif			6645	6741	2016-08-11 18:03:49	\N	268772630	3a718f65c91c6fe076dff512f4412d76		17	112
114	jpg			6645	6752	2016-08-11 18:03:54	\N	3003911	7e479dc72b4c9864054ccdf9bb37c63d		15	0
115	tif			6645	6752	2016-08-11 18:03:54	\N	269211200	43b6255243f38d6b99880d089acc7655		18	114
116	jpg			6645	6389	2016-08-11 18:03:59	\N	3017747	48f6a58d6e2567bb5cb46e6445b007e0		15	0
117	tif			6645	6389	2016-08-11 18:03:59	\N	254738390	b3026563fdbed74458d7f55dcda97e63		19	116
118	jpg			6645	6730	2016-08-11 18:03:38	\N	2930363	e006ab560a1074c7e9653b7ccb71c00f		15	0
119	tif			6645	6730	2016-08-11 18:03:38	\N	268334060	35b124a901b89a0a4396502f61fbe710		20	118
120	jpg			6645	6752	2016-08-11 18:03:33	\N	3157198	0884aad31547e9e383b430424a1b21fb		15	0
121	tif			6645	6752	2016-08-11 18:03:33	\N	269211200	60c60729818e633bbf3c5d389ca58ff2		21	120
122	tif			2779	4376	2011-09-28 17:45:34	\N	72974384	4e9bee45c1f842d2305f6026bc01b74b		22	0
123	tif			2779	4376	2011-09-28 17:46:30	\N	72974384	eaf9e18dc78158bdb829a434c48f164c		23	0
124	tif			2779	4376	2011-09-28 17:48:34	\N	72974384	8dcd28a239a3a1489a50e205c28226bf		24	0
125	tif			2779	4376	2011-09-28 17:47:42	\N	72974384	ab34e6a4a6fc2fbed9160d0737c12698		25	0
\.


--
-- Data for Name: pictags; Type: TABLE DATA; Schema: public; Owner: sch
--

COPY pictags (pic_id, tag_id, tag_id_num, doubt) FROM stdin;
1	10	1	0
1	10	2	0
1	10	3	0
2	10	1	0
2	10	2	0
2	10	4	0
3	10	1	0
3	10	2	0
3	10	5	0
4	10	1	0
4	10	6	0
4	10	2	0
5	10	7	0
5	10	1	0
5	10	2	0
6	10	8	0
6	10	10	0
6	10	9	0
6	10	11	0
6	10	12	0
6	10	2	0
7	10	8	0
7	10	10	0
7	10	9	0
7	10	11	0
7	10	12	0
7	10	2	0
8	10	8	0
8	10	10	0
8	10	9	0
8	10	13	0
8	10	12	0
8	10	2	0
9	10	8	0
9	10	10	0
9	10	9	0
9	10	13	0
9	10	12	0
9	10	2	0
10	10	14	0
10	10	8	0
10	10	10	0
10	10	9	0
10	10	12	0
10	10	2	0
11	10	14	0
11	10	8	0
11	10	10	0
11	10	9	0
11	10	12	0
11	10	2	0
12	10	15	0
12	10	8	0
12	10	10	0
12	10	9	0
12	10	12	0
12	10	2	0
13	10	15	0
13	10	8	0
13	10	10	0
13	10	9	0
13	10	12	0
13	10	2	0
14	10	16	0
14	10	8	0
14	10	10	0
14	10	9	0
14	10	12	0
14	10	2	0
15	10	16	0
15	10	8	0
15	10	10	0
15	10	9	0
15	10	12	0
15	10	2	0
16	10	8	0
16	10	10	0
16	10	9	0
16	10	17	0
16	10	12	0
16	10	2	0
17	10	8	0
17	10	10	0
17	10	9	0
17	10	17	0
17	10	12	0
17	10	2	0
18	10	8	0
18	10	10	0
18	10	9	0
18	10	18	0
18	10	12	0
18	10	2	0
19	10	8	0
19	10	10	0
19	10	9	0
19	10	18	0
19	10	12	0
19	10	2	0
20	10	8	0
20	10	10	0
20	10	9	0
20	10	19	0
20	10	12	0
20	10	2	0
21	10	8	0
21	10	10	0
21	10	9	0
21	10	19	0
21	10	12	0
21	10	2	0
22	10	8	0
22	10	10	0
22	10	9	0
22	10	20	0
22	10	12	0
22	10	2	0
23	10	8	0
23	10	10	0
23	10	9	0
23	10	20	0
23	10	12	0
23	10	2	0
24	10	8	0
24	10	10	0
24	10	9	0
24	10	21	0
24	10	12	0
24	10	2	0
25	10	8	0
25	10	10	0
25	10	9	0
25	10	21	0
25	10	12	0
25	10	2	0
26	10	22	0
26	10	2	0
26	10	23	0
27	10	22	0
27	10	24	0
27	10	2	0
28	10	25	0
28	10	26	0
28	10	2	0
29	10	27	0
29	10	25	0
29	10	2	0
30	10	28	0
30	10	29	0
30	10	2	0
31	10	29	0
31	10	30	0
31	10	2	0
32	10	31	0
32	10	2	0
32	10	32	0
33	10	33	0
33	10	31	0
33	10	2	0
34	10	31	0
34	10	34	0
34	10	2	0
35	10	31	0
35	10	35	0
35	10	2	0
36	10	31	0
36	10	2	0
36	10	36	0
37	10	31	0
37	10	37	0
37	10	2	0
38	10	31	0
38	10	38	0
38	10	2	0
39	10	39	0
39	10	31	0
39	10	2	0
40	10	31	0
40	10	40	0
40	10	2	0
41	10	41	0
41	10	31	0
41	10	2	0
42	10	42	0
42	10	31	0
42	10	2	0
43	10	31	0
43	10	43	0
43	10	2	0
44	10	31	0
44	10	2	0
44	10	44	0
45	10	45	0
45	10	31	0
45	10	2	0
46	10	31	0
46	10	46	0
46	10	2	0
47	10	31	0
47	10	47	0
47	10	2	0
48	10	48	0
48	10	31	0
48	10	2	0
49	10	31	0
49	10	49	0
49	10	2	0
50	10	50	0
50	10	31	0
50	10	2	0
51	10	31	0
51	10	2	0
51	10	51	0
52	10	31	0
52	10	52	0
52	10	2	0
53	10	53	0
53	10	31	0
53	10	2	0
54	10	31	0
54	10	54	0
54	10	2	0
55	10	31	0
55	10	55	0
55	10	2	0
56	10	56	0
56	10	57	0
56	10	2	0
57	10	57	0
57	10	58	0
57	10	2	0
58	10	59	0
58	10	60	0
58	10	12	0
58	10	61	0
59	10	62	0
59	10	60	0
59	10	12	0
59	10	61	0
60	10	63	0
60	10	60	0
60	10	12	0
60	10	61	0
61	10	64	0
61	10	60	0
61	10	12	0
61	10	61	0
62	10	65	0
62	10	66	0
62	10	61	0
62	10	67	0
63	10	65	0
63	10	68	0
63	10	69	0
63	10	61	0
64	10	65	0
64	10	68	0
64	10	70	0
64	10	61	0
65	10	71	0
65	10	65	0
65	10	68	0
65	10	61	0
66	10	72	0
66	10	65	0
66	10	73	0
66	10	61	0
67	10	74	0
67	10	65	0
67	10	73	0
67	10	61	0
68	10	75	0
68	10	65	0
68	10	73	0
68	10	61	0
69	10	76	0
69	10	65	0
69	10	77	0
69	10	61	0
70	10	65	0
70	10	78	0
70	10	77	0
70	10	61	0
71	10	65	0
71	10	79	0
71	10	61	0
71	10	80	0
72	10	65	0
72	10	61	0
72	10	81	0
72	10	80	0
73	10	82	0
73	10	65	0
73	10	83	0
73	10	61	0
74	10	65	0
74	10	83	0
74	10	84	0
74	10	61	0
75	10	85	0
75	10	65	0
75	10	83	0
75	10	61	0
76	10	86	0
76	10	65	0
76	10	83	0
76	10	61	0
77	10	87	0
77	10	65	0
77	10	88	0
77	10	61	0
78	10	65	0
78	10	88	0
78	10	61	0
78	10	89	0
79	10	90	0
79	10	65	0
79	10	91	0
79	10	61	0
80	10	92	0
80	10	65	0
80	10	93	0
80	10	61	0
81	10	92	0
81	10	65	0
81	10	94	0
81	10	61	0
82	10	95	0
82	10	92	0
82	10	65	0
82	10	61	0
83	10	96	0
83	10	65	0
83	10	97	0
83	10	61	0
84	10	98	0
84	10	65	0
84	10	97	0
84	10	61	0
85	10	65	0
85	10	99	0
85	10	97	0
85	10	61	0
86	10	100	0
86	10	65	0
86	10	61	0
86	10	101	0
87	10	100	0
87	10	65	0
87	10	102	0
87	10	61	0
88	10	100	0
88	10	65	0
88	10	61	0
88	10	103	0
89	10	65	0
89	10	104	0
89	10	105	0
89	10	61	0
90	10	106	0
90	10	65	0
90	10	107	0
90	10	61	0
91	10	106	0
91	10	108	0
91	10	65	0
91	10	61	0
92	10	106	0
92	10	65	0
92	10	61	0
92	10	109	0
93	10	65	0
93	10	61	0
93	10	110	0
93	10	111	0
94	10	65	0
94	10	61	0
94	10	111	0
94	10	112	0
95	10	113	0
95	10	65	0
95	10	114	0
95	10	61	0
96	10	113	0
96	10	65	0
96	10	115	0
96	10	61	0
97	10	116	0
97	10	65	0
97	10	61	0
97	10	117	0
98	10	118	0
98	10	65	0
98	10	119	0
98	10	61	0
99	10	118	0
99	10	65	0
99	10	61	0
99	10	120	0
100	10	121	0
100	10	12	0
100	10	61	0
100	10	122	0
101	10	121	0
101	10	12	0
101	10	61	0
101	10	122	0
102	10	121	0
102	10	12	0
102	10	61	0
102	10	123	0
103	10	121	0
103	10	12	0
103	10	61	0
103	10	123	0
104	10	124	0
104	10	121	0
104	10	12	0
104	10	61	0
105	10	124	0
105	10	121	0
105	10	12	0
105	10	61	0
106	10	125	0
106	10	121	0
106	10	12	0
106	10	61	0
107	10	125	0
107	10	121	0
107	10	12	0
107	10	61	0
108	10	121	0
108	10	12	0
108	10	126	0
108	10	61	0
109	10	121	0
109	10	12	0
109	10	126	0
109	10	61	0
110	10	121	0
110	10	12	0
110	10	61	0
110	10	127	0
111	10	121	0
111	10	12	0
111	10	61	0
111	10	127	0
112	10	121	0
112	10	12	0
112	10	61	0
112	10	128	0
113	10	121	0
113	10	12	0
113	10	61	0
113	10	128	0
114	10	121	0
114	10	12	0
114	10	61	0
114	10	129	0
115	10	121	0
115	10	12	0
115	10	61	0
115	10	129	0
116	10	121	0
116	10	12	0
116	10	61	0
116	10	130	0
117	10	121	0
117	10	12	0
117	10	61	0
117	10	130	0
118	10	121	0
118	10	12	0
118	10	61	0
118	10	131	0
119	10	121	0
119	10	12	0
119	10	61	0
119	10	131	0
120	10	121	0
120	10	12	0
120	10	61	0
120	10	132	0
121	10	121	0
121	10	12	0
121	10	61	0
121	10	132	0
122	10	133	0
122	10	60	0
122	10	134	0
122	10	61	0
123	10	135	0
123	10	60	0
123	10	134	0
123	10	61	0
124	10	136	0
124	10	60	0
124	10	134	0
124	10	61	0
125	10	137	0
125	10	60	0
125	10	134	0
125	10	61	0
126	10	86	0
126	10	65	0
126	10	83	0
126	10	138	0
\.


--
-- Data for Name: tags; Type: TABLE DATA; Schema: public; Owner: sch
--

COPY tags (tag_id, tag_prt, tag_path, tag_name, pics_name, tag_type) FROM stdin;
1	1	//XMP-tiff:DateTime	Дата	date	0
1	2	//IFD0:ModifyDate		date	0
1	3	//PNG:ModifyDate		date	0
1	4	//System:FileModifyDate		date	0
2	1	//XMP-tiff:ImageWidth	Ширина	width	0
2	2	//IFD0:ImageWidth		width	0
2	3	//PNG:ImageWidth		width	0
2	4	//ExifIFD:ExifImageWidth		width	0
2	5	//File:ImageWidth		width	0
3	1	//XMP-tiff:ImageHeight	Высота	height	0
3	2	//IFD0:ImageHeight		height	0
3	3	//PNG:ImageHeight		height	0
3	4	//ExifIFD:ExifImageHeight		height	0
3	5	//File:ImageHeight		height	0
4	1	//XMP-xmp:Label	Коллекция		2
5	1	//XMP-dc:Title	Название	title	0
5	2	//XMP-photoshop:AuthorPosition		title	0
5	3	//IPTC:ObjectName		title	0
5	4	//IPTC:By-lineTitle		title	0
6	1	//ExifIFD:UserComment	Описание	subscr	0
6	2	//XMP-exif:UserComment		subscr	0
6	3	//XMP-dc:Description		subscr	0
6	4	//EXIF:ImageDescription		subscr	0
6	5	//XMP-photoshop:Headline		subscr	0
6	6	//IPTC:Caption-Abstract		subscr	0
6	7	//IPTC:Headline		subscr	0
7	1	//XMP-photoshop:Country	Страна		1
7	2	//IPTC:Country-PrimaryLocationName			1
8	1	//XMP-photoshop:State	Регион (штат)		1
8	2	//IPTC:Province-State			1
9	1	//XMP-photoshop:City	Город (населённый пункт)		1
9	2	//IPTC:City			1
10	1	//XMP-dc:Subject//rdf:li	Ключевые слова		2
10	2	//IPTC:Keywords			2
11	1	//XMP-dc:Creator//rdf:li	Автор(ы)		2
11	2	//XMP-tiff:Artist			2
11	3	//IFD0:Artist			2
11	4	//PNG:Artist			2
11	5	//XMP-pdf:Author			2
11	6	//PNG:Author			2
12	1	//XMP-xmp:Identifier//rdf:li	Преобразовано из		2
12	2	//XMP-dc:Identifier			2
13	1	//XMP-dc:Rights	Авторские права	rights	0
13	2	//XMP-tiff:Copyright		rights	0
13	3	//EXIF:Copyright		rights	0
13	4	//IPTC:CopyrightNotice		rights	0
0	0				0
\.


--
-- Data for Name: volumes; Type: TABLE DATA; Schema: public; Owner: sch
--

COPY volumes (vol_id, dirname, lock) FROM stdin;
0	\N	0
1	Vol1	0
2	Vol1	0
3	Vol1	0
4	Vol1	0
5	Vol1	0
6	Vol1	0
7	Vol1	0
8	Vol1	0
9	Vol2	0
10	Vol2	0
11	Vol2	0
12	Vol2	0
13	Vol2	0
14	Vol2	0
15	Vol2	0
16	Vol2	0
17	Vol2	0
18	Vol2	0
19	Vol2	0
20	Vol2	0
21	Vol2	0
22	Vol2	0
23	Vol2	0
24	Vol2	0
25	Vol2	0
26	Vol4	0
\.


--
-- Name: gkwords_pkey; Type: CONSTRAINT; Schema: public; Owner: sch; Tablespace: 
--

ALTER TABLE ONLY gkwords
    ADD CONSTRAINT gkwords_pkey PRIMARY KEY (gkword_id);


--
-- Name: kwords_tag_id_tag_id_num_key; Type: CONSTRAINT; Schema: public; Owner: sch; Tablespace: 
--

ALTER TABLE ONLY kwords
    ADD CONSTRAINT kwords_tag_id_tag_id_num_key UNIQUE (tag_id, tag_id_num);


--
-- Name: pics_pkey; Type: CONSTRAINT; Schema: public; Owner: sch; Tablespace: 
--

ALTER TABLE ONLY pics
    ADD CONSTRAINT pics_pkey PRIMARY KEY (pic_id);


--
-- Name: pictags_pic_id_tag_id_tag_id_num_key; Type: CONSTRAINT; Schema: public; Owner: sch; Tablespace: 
--

ALTER TABLE ONLY pictags
    ADD CONSTRAINT pictags_pic_id_tag_id_tag_id_num_key UNIQUE (pic_id, tag_id, tag_id_num);


--
-- Name: tags_pkey; Type: CONSTRAINT; Schema: public; Owner: sch; Tablespace: 
--

ALTER TABLE ONLY tags
    ADD CONSTRAINT tags_pkey PRIMARY KEY (tag_id, tag_prt);


--
-- Name: volumes_pkey; Type: CONSTRAINT; Schema: public; Owner: sch; Tablespace: 
--

ALTER TABLE ONLY volumes
    ADD CONSTRAINT volumes_pkey PRIMARY KEY (vol_id);


--
-- Name: kwords_gkword_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: sch
--

ALTER TABLE ONLY kwords
    ADD CONSTRAINT kwords_gkword_id_fkey FOREIGN KEY (gkword_id) REFERENCES gkwords(gkword_id);


--
-- Name: pics_vol_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: sch
--

ALTER TABLE ONLY pics
    ADD CONSTRAINT pics_vol_id_fkey FOREIGN KEY (vol_id) REFERENCES volumes(vol_id);


--
-- Name: pictags_pic_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: sch
--

ALTER TABLE ONLY pictags
    ADD CONSTRAINT pictags_pic_id_fkey FOREIGN KEY (pic_id) REFERENCES pics(pic_id);


--
-- Name: pictags_tag_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: sch
--

ALTER TABLE ONLY pictags
    ADD CONSTRAINT pictags_tag_id_fkey FOREIGN KEY (tag_id, tag_id_num) REFERENCES kwords(tag_id, tag_id_num);


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- Name: gkwords; Type: ACL; Schema: public; Owner: sch
--

REVOKE ALL ON TABLE gkwords FROM PUBLIC;
REVOKE ALL ON TABLE gkwords FROM sch;
GRANT ALL ON TABLE gkwords TO sch;
GRANT ALL ON TABLE gkwords TO "www-data";


--
-- Name: kwords; Type: ACL; Schema: public; Owner: sch
--

REVOKE ALL ON TABLE kwords FROM PUBLIC;
REVOKE ALL ON TABLE kwords FROM sch;
GRANT ALL ON TABLE kwords TO sch;
GRANT ALL ON TABLE kwords TO "www-data";


--
-- Name: locktable; Type: ACL; Schema: public; Owner: sch
--

REVOKE ALL ON TABLE locktable FROM PUBLIC;
REVOKE ALL ON TABLE locktable FROM sch;
GRANT ALL ON TABLE locktable TO sch;
GRANT ALL ON TABLE locktable TO "www-data";


--
-- Name: pics; Type: ACL; Schema: public; Owner: sch
--

REVOKE ALL ON TABLE pics FROM PUBLIC;
REVOKE ALL ON TABLE pics FROM sch;
GRANT ALL ON TABLE pics TO sch;
GRANT ALL ON TABLE pics TO "www-data";


--
-- Name: pictags; Type: ACL; Schema: public; Owner: sch
--

REVOKE ALL ON TABLE pictags FROM PUBLIC;
REVOKE ALL ON TABLE pictags FROM sch;
GRANT ALL ON TABLE pictags TO sch;
GRANT ALL ON TABLE pictags TO "www-data";


--
-- Name: tags; Type: ACL; Schema: public; Owner: sch
--

REVOKE ALL ON TABLE tags FROM PUBLIC;
REVOKE ALL ON TABLE tags FROM sch;
GRANT ALL ON TABLE tags TO sch;
GRANT ALL ON TABLE tags TO "www-data";


--
-- Name: volumes; Type: ACL; Schema: public; Owner: sch
--

REVOKE ALL ON TABLE volumes FROM PUBLIC;
REVOKE ALL ON TABLE volumes FROM sch;
GRANT ALL ON TABLE volumes TO sch;
GRANT ALL ON TABLE volumes TO "www-data";


--
-- PostgreSQL database dump complete
--


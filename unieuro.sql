--
-- PostgreSQL database dump
--

-- Dumped from database version 12.2 (Ubuntu 12.2-4)
-- Dumped by pg_dump version 12.2 (Ubuntu 12.2-4)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: items; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.items (
    id integer NOT NULL,
    name character varying NOT NULL,
    brand character varying,
    unit character varying(5) NOT NULL,
    formula character varying,
    molecular_weight character varying,
    concentration character varying
);


ALTER TABLE public.items OWNER TO postgres;

--
-- Name: items_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.items_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.items_id_seq OWNER TO postgres;

--
-- Name: items_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.items_id_seq OWNED BY public.items.id;


--
-- Name: items_orders; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.items_orders (
    order_id integer,
    item_id integer,
    qtd integer NOT NULL
);


ALTER TABLE public.items_orders OWNER TO postgres;

--
-- Name: lots; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.lots (
    id integer NOT NULL,
    description character varying NOT NULL,
    expiration timestamp without time zone,
    qtd numeric NOT NULL,
    item_id integer,
    open boolean DEFAULT false
);


ALTER TABLE public.lots OWNER TO postgres;

--
-- Name: lots_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.lots_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.lots_id_seq OWNER TO postgres;

--
-- Name: lots_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.lots_id_seq OWNED BY public.lots.id;


--
-- Name: menus; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.menus (
    id integer NOT NULL,
    name character varying NOT NULL,
    path character varying NOT NULL,
    icon character varying
);


ALTER TABLE public.menus OWNER TO postgres;

--
-- Name: menus_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.menus_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.menus_id_seq OWNER TO postgres;

--
-- Name: menus_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.menus_id_seq OWNED BY public.menus.id;


--
-- Name: menus_roles; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.menus_roles (
    role_id integer,
    menu_id integer
);


ALTER TABLE public.menus_roles OWNER TO postgres;

--
-- Name: orders; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.orders (
    id integer NOT NULL,
    user_id integer NOT NULL,
    created_at timestamp without time zone DEFAULT now(),
    due_date timestamp without time zone NOT NULL,
    status boolean DEFAULT true,
    dispatched boolean DEFAULT false
);


ALTER TABLE public.orders OWNER TO postgres;

--
-- Name: orders_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.orders_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.orders_id_seq OWNER TO postgres;

--
-- Name: orders_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.orders_id_seq OWNED BY public.orders.id;


--
-- Name: roles; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.roles (
    id integer NOT NULL,
    description character varying NOT NULL
);


ALTER TABLE public.roles OWNER TO postgres;

--
-- Name: roles_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.roles_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.roles_id_seq OWNER TO postgres;

--
-- Name: roles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.roles_id_seq OWNED BY public.roles.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id integer NOT NULL,
    username character varying NOT NULL,
    email character varying NOT NULL,
    password character varying NOT NULL,
    role_id integer NOT NULL
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: items id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.items ALTER COLUMN id SET DEFAULT nextval('public.items_id_seq'::regclass);


--
-- Name: lots id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.lots ALTER COLUMN id SET DEFAULT nextval('public.lots_id_seq'::regclass);


--
-- Name: menus id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menus ALTER COLUMN id SET DEFAULT nextval('public.menus_id_seq'::regclass);


--
-- Name: orders id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.orders ALTER COLUMN id SET DEFAULT nextval('public.orders_id_seq'::regclass);


--
-- Name: roles id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.roles ALTER COLUMN id SET DEFAULT nextval('public.roles_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Data for Name: items; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.items (id, name, brand, unit, formula, molecular_weight, concentration) FROM stdin;
2	Água para Injeção 10ml	Equipex	UN	\N	\N	\N
3	Equipo Macrogotas	Labor Import	UN	\N	\N	\N
1	Luva	Latex	UN	\N	\N	\N
4	Luva 2	Latex 2	UN	\N	\N	\N
5	Luva 2	Latex 2	UN	\N	\N	\N
6	Luva 2	Latex 2	UN	\N	\N	\N
7	Açúcar	Cristal	KG	\N	\N	\N
\.


--
-- Data for Name: items_orders; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.items_orders (order_id, item_id, qtd) FROM stdin;
5	1	2
6	1	12
6	2	46
6	3	85
7	1	12
7	2	64
8	1	1
9	1	1
10	1	1
11	1	2
12	1	1
13	1	12
14	1	12
15	1	12
16	1	2
17	1	2
18	1	450
18	2	6500
18	3	54
19	1	12
20	3	100
21	1	2
22	2	12
23	2	2
23	3	3
23	1	4
24	2	15
24	3	15
24	1	15
25	2	12
25	3	12
25	1	12
26	2	12
26	3	22
26	1	23
27	2	10
28	2	20
28	3	20
\.


--
-- Data for Name: lots; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.lots (id, description, expiration, qtd, item_id, open) FROM stdin;
3	SEMAAA0004	2022-05-17 00:10:06.97	283	3	f
2	123456	2020-12-31 00:00:00	243	1	f
4	asdfqerw	2021-12-28 05:22:18.433	0	1	f
6	asdf	2022-12-30 20:40:45.752	1000	2	f
5	asdfafs	2021-07-28 05:59:44.321	150	2	f
1	123456	2020-12-31 00:00:00	44	1	f
7	Teste	2020-07-30 22:59:14.305	2	4	f
8	abc	2021-01-01 03:00:00	500	7	\N
\.


--
-- Data for Name: menus; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.menus (id, name, path, icon) FROM stdin;
1	Itens	/items	\N
2	Pedidos	/orders	\N
3	Usuários	/users	\N
4	Perfis	/roles	\N
5	Menus	/menus	\N
6	Novo pedido	/orders/new	\N
7	Acessos	/permissions	\N
8	Meus pedidos	/users/myorders	\N
\.


--
-- Data for Name: menus_roles; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.menus_roles (role_id, menu_id) FROM stdin;
1	1
1	2
1	3
2	5
2	2
2	4
2	3
2	7
4	6
4	8
2	1
\.


--
-- Data for Name: orders; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.orders (id, user_id, created_at, due_date, status, dispatched) FROM stdin;
9	2	2020-07-19 17:19:54.64826	2020-07-23 20:19:00	t	f
10	2	2020-07-19 17:26:10.100693	2020-07-21 20:26:00	t	f
11	2	2020-07-19 17:28:35.51576	2020-07-22 20:28:00	t	f
12	2	2020-07-19 17:34:37.749202	2020-07-24 20:34:00	t	f
13	2	2020-07-19 20:01:56.227233	2020-07-23 23:01:00	t	f
14	2	2020-07-19 20:23:29.615778	2020-07-22 23:23:00	t	f
15	2	2020-07-19 21:03:56.963426	2020-07-25 00:03:00	t	f
16	2	2020-07-20 17:00:00.754057	2020-07-24 19:59:00	t	f
17	2	2020-07-20 18:37:17.81389	2020-12-31 21:37:00	t	f
18	2	2020-07-20 22:51:43.54751	2020-07-23 01:51:00	t	f
19	6	2020-07-26 03:38:00.199899	2020-07-29 06:37:00	t	f
6	2	2020-07-19 16:19:32.25651	2020-07-30 19:19:00	t	t
5	2	2020-07-19 16:16:28.751226	2020-07-23 19:06:00	t	t
20	6	2020-07-27 00:04:55.864803	2020-07-27 03:04:00	t	t
21	6	2020-07-28 02:23:04.643306	2020-07-31 05:22:00	t	t
7	2	2020-07-19 17:15:05.023853	2020-07-21 20:14:00	t	t
22	6	2020-07-28 03:10:42.3092	2020-08-21 06:10:00	t	f
23	6	2020-07-28 20:43:48.393273	2020-07-30 23:43:00	t	f
24	8	2020-07-30 01:02:39.109052	2020-08-21 04:02:00	t	f
25	8	2020-07-30 01:03:32.7659	2020-08-21 04:03:00	t	f
26	8	2020-07-30 02:39:04.744835	2020-07-31 05:38:00	t	f
27	8	2020-07-30 17:41:31.482997	2020-07-31 20:41:00	t	f
8	2	2020-07-19 17:16:04.287364	2020-09-24 20:15:00	t	t
28	8	2020-07-30 19:31:07.827663	2020-08-20 22:30:00	t	f
\.


--
-- Data for Name: roles; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.roles (id, description) FROM stdin;
1	Almoxarifado
2	Administração
4	Professores
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, username, email, password, role_id) FROM stdin;
2	Samuel Felipe	samfelgar@gmail.com	$2y$10$a2mJzcBbVTlBs9vyarbwtOUce3IJmSBVy285wVv5aF9Ql5EzdP3Om	1
8	Santana	santana@gmail.com	$2y$10$ia6DkinhpRF1n3XsIT.aj.YlLjSkutg.eijz6QDUOzzNAAXAvLH2i	4
6	Roberta Thuani	roberta@gmail.com	$2y$10$ai4oKrshladHQ9OhEd3dNuuprJFTUgMH6fiuJrr3G2zocHvo6WcPS	2
\.


--
-- Name: items_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.items_id_seq', 7, true);


--
-- Name: lots_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.lots_id_seq', 8, true);


--
-- Name: menus_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.menus_id_seq', 8, true);


--
-- Name: orders_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.orders_id_seq', 28, true);


--
-- Name: roles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.roles_id_seq', 4, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 8, true);


--
-- Name: items items_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.items
    ADD CONSTRAINT items_pkey PRIMARY KEY (id);


--
-- Name: lots lots_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.lots
    ADD CONSTRAINT lots_pkey PRIMARY KEY (id);


--
-- Name: menus menus_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menus
    ADD CONSTRAINT menus_pkey PRIMARY KEY (id);


--
-- Name: orders orders_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT orders_pkey PRIMARY KEY (id);


--
-- Name: roles roles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (id);


--
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: items_orders items_orders_item_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.items_orders
    ADD CONSTRAINT items_orders_item_id_fkey FOREIGN KEY (item_id) REFERENCES public.items(id);


--
-- Name: items_orders items_orders_order_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.items_orders
    ADD CONSTRAINT items_orders_order_id_fkey FOREIGN KEY (order_id) REFERENCES public.orders(id);


--
-- Name: lots lots_item_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.lots
    ADD CONSTRAINT lots_item_id_fkey FOREIGN KEY (item_id) REFERENCES public.items(id);


--
-- Name: menus_roles menus_roles_menu_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menus_roles
    ADD CONSTRAINT menus_roles_menu_id_fkey FOREIGN KEY (menu_id) REFERENCES public.menus(id);


--
-- Name: menus_roles menus_roles_role_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menus_roles
    ADD CONSTRAINT menus_roles_role_id_fkey FOREIGN KEY (role_id) REFERENCES public.roles(id);


--
-- Name: orders orders_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT orders_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(id);


--
-- Name: users users_role_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_role_id_fkey FOREIGN KEY (role_id) REFERENCES public.roles(id);


--
-- PostgreSQL database dump complete
--


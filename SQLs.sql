

INSERT INTO `categorias` (`id`, `created_at`, `updated_at`, `categoria`, `deleted_at`) VALUES
(1, NULL, '2019-06-27 23:41:11', 'Carro Novo', NULL),
(2, NULL, NULL, 'Carro usado', NULL),
(3, NULL, NULL, 'Carros fora de uso', NULL),
(4, NULL, NULL, 'Carros apenas para revenda de peças', NULL),
(5, NULL, '2019-06-27 08:42:38', 'Carros antigos', NULL),
(6, '2019-06-27 08:39:09', '2019-06-27 08:42:29', 'Carro novo', '2019-06-27 08:42:29'),
(7, NULL, NULL, 'Amassado', NULL),
(8, NULL, NULL, 'Torto', NULL),
(9, NULL, NULL, 'Verde', NULL),
(10, NULL, NULL, 'Azul', NULL),
(11, NULL, NULL, 'Cinza', NULL),
(12, NULL, NULL, 'Rosa', NULL),
(13, NULL, NULL, 'Fosco', NULL),
(14, NULL, NULL, 'Preto', NULL),
(15, NULL, NULL, 'Sem motor', NULL),
(16, NULL, NULL, 'Destruido', NULL),
(17, NULL, NULL, 'Batido', NULL),
(18, NULL, NULL, 'Multado', NULL);


NSERT INTO `produtos_categorias` (`produto_id`, `categoria_id`, `data_limite`, `created_at`, `updated_at`) VALUES
(1, 11, '29/10/2020', NULL, NULL),
(1, 9, '29/10/2020', NULL, NULL),
(1, 5, '29/10/2020', NULL, NULL),
(2, 7, '26/08/2019', NULL, NULL),
(3, 3, '29/10/2020', NULL, NULL),
(3, 1, '29/10/2020', NULL, NULL),
(1, 13, '29/10/2020', NULL, NULL),
(4, 4, '29/10/2020', NULL, NULL),
(5, 5, '29/10/2020', NULL, NULL);


INSERT INTO `produtos` (`id`, `produto`, `estoque`, `valor`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Ford ka 2019', 5, 290000.00, NULL, NULL, '2019-06-27 07:45:42'),
(2, 'Ford ka 2012', 2, 14000.00, NULL, NULL, '2019-06-27 07:52:32'),
(3, 'Celta 2012', 4, 10000.00, NULL, NULL, NULL),
(4, 'Focus 2016', 2, 20000.00, NULL, NULL, NULL),
(5, 'Cayman SS ', 1, 290000.00, NULL, NULL, NULL),
(6, 'GOL 1980', 2, 7000.00, '2019-06-27 07:45:54', NULL, '2019-06-27 07:45:54'),
(7, 'Carro desconhecidasso', 1, 3120.00, NULL, '2019-06-27 07:52:16', '2019-06-27 23:47:57'),
(8, 'Celta 2014', 1, 13000.00, '2019-06-27 23:49:28', '2019-06-27 23:32:47', '2019-06-27 23:49:28');

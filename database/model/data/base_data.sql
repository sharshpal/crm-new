SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `crm_user`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `crm_user` (`id`, `first_name`, `last_name`, `email`, `password`, `remember_token`, `activated`, `forbidden`, `language`, `created_at`, `updated_at`, `deleted_at`) VALUES (1, 'Admin', 'User', 'admin@crm.local', '$2y$10$kYFMwxxlBDdYZI/Am3cNbemcA.xI.XtjQruEZmAb.KZ3Azob440wC', NULL, 1, 0, 'it', NULL, NULL, NULL);
INSERT INTO `crm_user` (`id`, `first_name`, `last_name`, `email`, `password`, `remember_token`, `activated`, `forbidden`, `language`, `created_at`, `updated_at`, `deleted_at`) VALUES (2, 'Doctor', 'User', 'doctor@crm.local', '$2y$10$kYFMwxxlBDdYZI/Am3cNbemcA.xI.XtjQruEZmAb.KZ3Azob440wC', NULL, 1, 0, 'it', NULL, NULL, NULL);
INSERT INTO `crm_user` (`id`, `first_name`, `last_name`, `email`, `password`, `remember_token`, `activated`, `forbidden`, `language`, `created_at`, `updated_at`, `deleted_at`) VALUES (3, 'Segretaria', 'Medico', 'segretaria@crm.local', '$2y$10$kYFMwxxlBDdYZI/Am3cNbemcA.xI.XtjQruEZmAb.KZ3Azob440wC', NULL, 1, 0, 'it', NULL, NULL, NULL);
INSERT INTO `crm_user` (`id`, `first_name`, `last_name`, `email`, `password`, `remember_token`, `activated`, `forbidden`, `language`, `created_at`, `updated_at`, `deleted_at`) VALUES (4, 'Cliente', 'User', 'customer@crm.local', '$2y$10$kYFMwxxlBDdYZI/Am3cNbemcA.xI.XtjQruEZmAb.KZ3Azob440wC', NULL, 1, 0, 'it', NULL, NULL, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `roles`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (1, 'Admin', 'admin', NULL, NULL);
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (2, 'Doctor', 'admin', NULL, NULL);
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (3, 'Segretaria', 'admin', NULL, NULL);
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (4, 'Cliente', 'admin', NULL, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `permissions`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (2, 'admin', 'admin', 'Admin Base', '2019-10-08 22:53:17', '2019-10-08 22:53:17');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (3, 'admin.translation.index', 'admin', 'Elenco', '2019-10-08 22:53:17', '2019-10-08 22:53:17');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (4, 'admin.translation.edit', 'admin', 'Modifica', '2019-10-08 22:53:17', '2019-10-08 22:53:17');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (5, 'admin.translation.rescan', 'admin', 'Rescan', '2019-10-08 22:53:17', '2019-10-08 22:53:17');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (6, 'admin.user.index', 'admin', 'Elenco', '2019-10-08 22:53:17', '2019-10-08 22:53:17');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (7, 'admin.user.create', 'admin', 'Crea', '2019-10-08 22:53:17', '2019-10-08 22:53:17');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (8, 'admin.user.edit', 'admin', 'Modifica', '2019-10-08 22:53:17', '2019-10-08 22:53:17');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (9, 'admin.user.delete', 'admin', 'Elimina', '2019-10-08 22:53:17', '2019-10-08 22:53:17');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (10, 'admin.upload', 'admin', 'Upload File', '2019-10-08 22:53:17', '2019-10-08 22:53:17');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (11, 'admin.role', 'admin', 'Ruoli', '2019-10-08 22:53:17', '2019-10-08 22:53:17');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (12, 'admin.role.index', 'admin', 'Elenco', '2019-10-08 22:53:17', '2019-10-08 22:53:17');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (13, 'admin.role.create', 'admin', 'Crea', '2019-10-08 22:53:17', '2019-10-08 22:53:17');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (14, 'admin.role.edit', 'admin', 'Modifica', '2019-10-08 22:53:17', '2019-10-08 22:53:17');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (15, 'admin.role.delete', 'admin', 'Elimina', '2019-10-08 22:53:17', '2019-10-08 22:53:17');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (16, 'admin.role.show', 'admin', 'Visualizza Dettaglio', '2019-10-08 22:53:17', '2019-10-08 22:53:17');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (17, 'widget.inspiring_quote', 'admin', 'Widget Frasi', '2019-10-08 22:53:17', '2019-10-08 22:53:17');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (18, 'widget.user_info', 'admin', 'Widget Info Utente', '2019-10-08 22:53:17', '2019-10-08 22:53:17');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (19, 'admin.specialization', 'admin', 'Specializzazioni', '2019-10-15 18:45:14', '2019-10-15 18:45:14');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (20, 'admin.specialization.index', 'admin', 'Elenco', '2019-10-15 18:45:14', '2019-10-15 18:45:14');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (21, 'admin.specialization.create', 'admin', 'Crea', '2019-10-15 18:45:14', '2019-10-15 18:45:14');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (22, 'admin.specialization.show', 'admin', 'Visulizza Dettaglio', '2019-10-15 18:45:14', '2019-10-15 18:45:14');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (23, 'admin.specialization.edit', 'admin', 'Modifica', '2019-10-15 18:45:14', '2019-10-15 18:45:14');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (24, 'admin.specialization.delete', 'admin', 'Elimina', '2019-10-15 18:45:14', '2019-10-15 18:45:14');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (25, 'admin.doctor', 'admin', 'Medico', '2019-10-15 20:38:57', '2019-10-15 20:38:57');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (26, 'admin.doctor.index', 'admin', 'Elenco', '2019-10-15 20:38:57', '2019-10-15 20:38:57');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (27, 'admin.doctor.create', 'admin', 'Crea', '2019-10-15 20:38:57', '2019-10-15 20:38:57');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (28, 'admin.doctor.show', 'admin', 'Visualizza Dettaglio', '2019-10-15 20:38:57', '2019-10-15 20:38:57');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (29, 'admin.doctor.edit', 'admin', 'Modifica', '2019-10-15 20:38:57', '2019-10-15 20:38:57');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (30, 'admin.doctor.delete', 'admin', 'Elimina', '2019-10-15 20:38:57', '2019-10-15 20:38:57');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (31, 'admin.customer', 'admin', 'Cliente', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (32, 'admin.customer.index', 'admin', 'Elenco', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (33, 'admin.customer.create', 'admin', 'Crea', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (34, 'admin.customer.show', 'admin', 'Dettaglio', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (35, 'admin.customer.edit', 'admin', 'Modifica', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (36, 'admin.customer.delete', 'admin', 'Elimina', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (37, 'customer', 'admin', 'Cooperativa', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (38, 'doctor', 'admin', 'Medico', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (39, 'doctor.account.list', 'admin', 'Utenti Autorizzati', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (40, 'customer.account.list', 'admin', 'Utenti Autorizzati', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (41, 'customer.doctor.list', 'admin', 'Elenco Medici', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (42, 'doctor.profile.edit', 'admin', 'Modifica Profilo', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (43, 'customer.profile.edit', 'admin', 'Modifica Profilo', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (44, 'doctor.profile.associate_user', 'admin', 'Associa Account', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (45, 'customer.profile.associate_user', 'admin', 'Associa Account', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (46, 'customer.profile.associate_doctor', 'admin', 'Associa Medico', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (47, 'admin.patients-list-type', 'admin', 'Tipo Lista Pazienti', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (48, 'admin.patients-list-type.index', 'admin', 'Elenco', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (49, 'admin.patients-list-type.create', 'admin', 'Crea', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (50, 'admin.patients-list-type.edit', 'admin', 'Modifica', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (51, 'admin.patients-list-type.delete', 'admin', 'Elimina', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (52, 'admin.patients-list-type.show', 'admin', 'Dettaglio', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (53, 'admin.patient', 'admin', 'Pazienti', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (54, 'admin.patient.index', 'admin', 'Elenco', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (55, 'admin.patient.create', 'admin', 'Crea', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (56, 'admin.patient.edit', 'admin', 'Modifica', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (57, 'admin.patient.show', 'admin', 'Dettaglio', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (58, 'admin.patient.delete', 'admin', 'Elimina', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (59, 'admin.patients-list', 'admin', 'Liste Pazienti', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (60, 'admin.patients-list.index', 'admin', 'Elenco', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (61, 'admin.patients-list.create', 'admin', 'Crea', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (62, 'admin.patients-list.show', 'admin', 'Visualizza Dettaglio', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (63, 'admin.patients-list.delete', 'admin', 'Elimina', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (64, 'admin.patients-list.edit', 'admin', 'Modifica', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (65, 'doctor.patient', 'admin', 'Pazienti', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (66, 'doctor.patient.index', 'admin', 'Elenco', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (67, 'doctor.patient.create', 'admin', 'Crea', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (68, 'doctor.patient.edit', 'admin', 'Modifica', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (69, 'doctor.patient.show', 'admin', 'Visualizza Dettaglio', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (70, 'doctor.patient.delete', 'admin', 'Elimina', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (71, 'doctor.patients-list', 'admin', 'Liste Pazienti', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (72, 'doctor.patients-list.index', 'admin', 'Elenco', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (73, 'doctor.patients-list.create', 'admin', 'Crea', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (74, 'doctor.patients-list.show', 'admin', 'Dettaglio', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (75, 'doctor.patients-list.delete', 'admin', 'Elimina', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (76, 'doctor.patients-list.edit', 'admin', 'Modifica', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (77, 'doctor.managed.list', 'admin', 'Elenco Medici Gestiti', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (78, 'customer.managed.list', 'admin', 'Elenco Clienti Gestiti', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (79, 'doctor.profile.associate_customer', 'admin', 'Associa Cliente', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (80, 'admin.activity-type', 'admin', 'Tipi Attività', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (81, 'admin.activity-type.index', 'admin', 'Elenco', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (82, 'admin.activity-type.create', 'admin', 'Crea', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (83, 'admin.activity-type.edit', 'admin', 'Modifica', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (84, 'admin.activity-type.delete', 'admin', 'Elimina', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (85, 'admin.activity-type.show', 'admin', 'Visualizza Dettaglio', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (86, 'admin.request-model', 'admin', 'Modelli Richiesta', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (87, 'admin.request-model.index', 'admin', 'Elenco', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (88, 'admin.request-model.create', 'admin', 'Crea', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (89, 'admin.request-model.edit', 'admin', 'Modifica', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (90, 'admin.request-model.show', 'admin', 'Visualizza Dettaglio', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (91, 'admin.request-model.delete', 'admin', 'Elimina', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (92, 'admin.calendar-model.index', 'admin', 'Elenco', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (93, 'admin.calendar-model.create', 'admin', 'Crea', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (94, 'admin.calendar-model.edit', 'admin', 'Modifica', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (95, 'admin.calendar-model.delete', 'admin', 'Admin', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (96, 'admin.calendar-model.show', 'admin', 'Visualizza Dettaglio', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (97, 'admin.main-request', 'admin', 'Richieste', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (98, 'admin.main-request.index', 'admin', 'Elenco', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (99, 'admin.main-request.create', 'admin', 'Crea', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (100, 'admin.main-request.edit', 'admin', 'Modifica', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (101, 'admin.main-request.show', 'admin', 'Visualizza Dettaglio', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (102, 'admin.main-request.delete', 'admin', 'Elimina', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (103, 'admin.request-model.get-activity', 'admin', 'Elenco Attività', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (110, 'admin.doctor-office', 'admin', 'Studio Medico', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (111, 'admin.doctor-office.index', 'admin', 'Elenco', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (112, 'admin.doctor-office.create', 'admin', 'Crea', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (113, 'admin.doctor-office.edit', 'admin', 'Modifica', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (114, 'admin.doctor-office.delete', 'admin', 'Elimina', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (115, 'admin.doctor-office.show', 'admin', 'Visualizza Dettaglio', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (116, 'admin.activity-execution', 'admin', 'Attività in Corso', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (117, 'admin.activity-execution.index', 'admin', 'Elenco', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (118, 'admin.activity-execution.create', 'admin', 'Crea', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (119, 'admin.activity-execution.edit', 'admin', 'Modifica', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (120, 'admin.activity-execution.delete', 'admin', 'Elimina', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (121, 'admin.activity-execution.show', 'admin', 'Visualizza Dettaglio', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (122, 'admin.main-request.activate', 'admin', 'Attiva', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (123, 'activity', 'admin', 'Attività', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (124, 'activity.backlog', 'admin', 'Backlog', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (125, 'activity.backlog.index', 'admin', 'Lista Backlog', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (126, 'activity.management', 'admin', 'Gestione', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (127, 'activity.management.open', 'admin', 'Apertura', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (128, 'activity.management.manage', 'admin', 'Lavorazione', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (129, 'activity.management.storeManaged', 'admin', 'Salva Lavorazione', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (130, 'activity.management.deleteManaged', 'admin', 'Elimina Lavorazione', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (131, 'doctor.main-request', 'admin', 'Richieste Dottore', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (132, 'doctor.main-request.index', 'admin', 'Elenco Richieste', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (133, 'activity.management.rescheduleManaged', 'admin', 'Rischedula Attività Chiusa', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (134, 'admin.patients-list.export', 'admin', 'Esporta Lista Pazienti', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (135, 'doctor.patients-list.export', 'admin', 'Esporta Lista Pazienti', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (136, 'admin.ats', 'admin', 'ATS', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (137, 'admin.ats.index', 'admin', 'Elenco', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (138, 'admin.ats.create', 'admin', 'Crea', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (139, 'admin.ats.edit', 'admin', 'Modifica', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (140, 'admin.ats.delete', 'admin', 'Elimina', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (141, 'admin.export-report', 'admin', 'Esporta Report', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (142, 'admin.export-report.index', 'admin', 'Elenco', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (143, 'admin.export-report.create', 'admin', 'Crea', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (144, 'admin.export-report.edit', 'admin', 'Modifica', '2019-10-15 21:04:19', '2019-10-15 21:04:19');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `label`, `created_at`, `updated_at`) VALUES (145, 'admin.export-report.delete', 'admin', 'Elimina', '2019-10-15 21:04:19', '2019-10-15 21:04:19');

COMMIT;


-- -----------------------------------------------------
-- Data for table `model_has_roles`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES (1, 'App\\Models\\CrmUser', 1);
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES (2, 'App\\Models\\CrmUser', 2);
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES (3, 'App\\Models\\CrmUser', 3);
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES (4, 'App\\Models\\CrmUser', 4);

COMMIT;


-- -----------------------------------------------------
-- Data for table `role_has_permissions`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 2);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 3);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 4);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 5);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 6);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 7);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 8);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 9);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 10);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (2, 10);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (3, 10);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (4, 10);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 11);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 12);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 13);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 14);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 15);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 16);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 17);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (2, 17);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (3, 17);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (4, 17);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 18);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (2, 18);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (3, 18);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (4, 18);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 19);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 20);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 21);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 22);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 23);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 24);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 25);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 26);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 27);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 28);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 29);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 30);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 31);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 32);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 33);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 34);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 35);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 36);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 37);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (4, 37);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 38);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (2, 38);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (3, 38);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (2, 39);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (4, 40);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (4, 41);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (2, 42);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (3, 42);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (4, 43);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (2, 44);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (4, 46);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 47);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 48);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 49);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 50);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 51);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 52);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 53);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 54);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 55);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 56);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 57);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 58);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 59);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 60);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 61);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 62);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 63);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 64);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (2, 65);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (2, 66);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (2, 67);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (2, 68);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (2, 69);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (2, 70);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (2, 71);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (2, 72);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (2, 73);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (2, 74);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (2, 75);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (2, 76);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (3, 65);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (3, 66);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (3, 67);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (3, 68);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (3, 69);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (3, 70);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (3, 71);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (3, 72);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (3, 73);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (3, 74);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (3, 75);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (3, 76);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (2, 77);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (3, 77);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (4, 78);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (2, 79);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (3, 79);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 80);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 81);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 82);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 83);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 84);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 85);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 86);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 87);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 88);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 89);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 90);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 91);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 92);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 93);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 94);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 95);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 96);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 97);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 98);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 99);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 100);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 101);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 102);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 103);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 110);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 111);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 112);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 113);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 114);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 115);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 116);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 117);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 118);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 119);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 120);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 121);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 122);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (2, 123);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (2, 124);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (2, 125);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (3, 123);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (3, 124);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (3, 125);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (2, 126);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (2, 127);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (2, 128);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (3, 126);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (3, 127);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (3, 128);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (2, 129);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (3, 129);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (2, 130);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (3, 130);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (2, 131);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (2, 132);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (3, 133);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 134);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (2, 135);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (3, 135);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 136);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 137);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 138);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 139);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 140);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 141);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 142);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 143);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 144);
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES (1, 145);

COMMIT;


-- -----------------------------------------------------
-- Data for table `doctor`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `doctor` (`id`, `first_name`, `last_name`, `email`, `phone`, `forbidden`, `fiscal_code`, `area_riferimento`, `centro_riferimento`) VALUES (1, 'Mario', 'Rossi', 'mario@rossi.it', '12345670', 0, NULL, NULL, NULL);
INSERT INTO `doctor` (`id`, `first_name`, `last_name`, `email`, `phone`, `forbidden`, `fiscal_code`, `area_riferimento`, `centro_riferimento`) VALUES (2, 'Luigi', 'Verdi', 'luigi@verdi.it', '12345670', 0, NULL, NULL, NULL);
INSERT INTO `doctor` (`id`, `first_name`, `last_name`, `email`, `phone`, `forbidden`, `fiscal_code`, `area_riferimento`, `centro_riferimento`) VALUES (3, 'Giuseppe', 'Bianchi', 'giuseppe@bianchi.it', '12345670', 0, NULL, NULL, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `specialization`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `specialization` (`id`, `name`, `description`) VALUES (1, 'Gastroenterologia', NULL);
INSERT INTO `specialization` (`id`, `name`, `description`) VALUES (2, 'Ortopedia', NULL);
INSERT INTO `specialization` (`id`, `name`, `description`) VALUES (3, 'Ginecologia', NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `doctor_specializations`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `doctor_specializations` (`doctor`, `specialization`) VALUES (1, 1);

COMMIT;


-- -----------------------------------------------------
-- Data for table `doctor_user_accounts`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `doctor_user_accounts` (`doctor`, `crm_user`, `super_admin`) VALUES (1, 2, DEFAULT);
INSERT INTO `doctor_user_accounts` (`doctor`, `crm_user`, `super_admin`) VALUES (1, 3, DEFAULT);
INSERT INTO `doctor_user_accounts` (`doctor`, `crm_user`, `super_admin`) VALUES (2, 3, DEFAULT);
INSERT INTO `doctor_user_accounts` (`doctor`, `crm_user`, `super_admin`) VALUES (3, 3, DEFAULT);

COMMIT;


-- -----------------------------------------------------
-- Data for table `customer`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `customer` (`id`, `name`, `description`, `forbidden`) VALUES (1, 'Cliente1', 'record di prova', 0);
INSERT INTO `customer` (`id`, `name`, `description`, `forbidden`) VALUES (2, 'Cliente2', 'record di prova', 0);

COMMIT;


-- -----------------------------------------------------
-- Data for table `customer_user_accounts`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `customer_user_accounts` (`customer`, `crm_user`, `super_admin`) VALUES (1, 4, DEFAULT);

COMMIT;


-- -----------------------------------------------------
-- Data for table `customer_has_doctor`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `customer_has_doctor` (`customer`, `doctor`) VALUES (1, 1);
INSERT INTO `customer_has_doctor` (`customer`, `doctor`) VALUES (1, 2);
INSERT INTO `customer_has_doctor` (`customer`, `doctor`) VALUES (1, 3);

COMMIT;


-- -----------------------------------------------------
-- Data for table `migrations`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1, '2017_08_24_000000_create_crm_user_activations_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (2, '2017_08_24_000000_create_crm_user_password_resets_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (3, '2017_08_24_000000_create_crm_user_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (4, '2018_07_18_000000_create_wysiwyg_media_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (5, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (6, '2019_10_06_222142_create_media_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (7, '2019_10_06_222142_create_permission_tables', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (8, '2019_10_06_222142_create_translations_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (9, '2019_10_06_222146_fill_permissions_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (10, '2019_10_06_222147_fill_default_crm_user_and_permissions', 1);

COMMIT;


-- -----------------------------------------------------
-- Data for table `media`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `media` (`id`, `model_type`, `model_id`, `collection_name`, `name`, `file_name`, `mime_type`, `disk`, `size`, `manipulations`, `custom_properties`, `responsive_images`, `order_column`, `created_at`, `updated_at`) VALUES (2, 'App\\Models\\CrmUser', 2, 'avatar', 'avatar', 'avatar.png', 'image/png', 'media', 23924, '[]', '{\"generated_conversions\": {\"thumb_75\": true, \"thumb_150\": true, \"thumb_200\": true}}', '[]', 2, '2019-10-08 22:53:17', '2019-10-08 22:53:17');
INSERT INTO `media` (`id`, `model_type`, `model_id`, `collection_name`, `name`, `file_name`, `mime_type`, `disk`, `size`, `manipulations`, `custom_properties`, `responsive_images`, `order_column`, `created_at`, `updated_at`) VALUES (3, 'App\\Models\\CrmUser', 1, 'avatar', 'CTQGdJESi8zTrE3Jm3uPSoU7rZFcyOKURaHuu6Za', 'CTQGdJESi8zTrE3Jm3uPSoU7rZFcyOKURaHuu6Za.jpeg', 'image/jpeg', 'media', 5835, '[]', '{\"name\": \"download (1).jpg\", \"width\": 275, \"height\": 183, \"file_name\": \"download (1).jpg\", \"generated_conversions\": {\"thumb_75\": true, \"thumb_150\": true, \"thumb_200\": true}}', '[]', 3, '2019-10-08 23:48:30', '2019-10-08 23:48:30');

COMMIT;


-- -----------------------------------------------------
-- Data for table `patients_list_types`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `patients_list_types` (`id`, `scope`, `max_duration_days`, `created_at`, `updated_at`) VALUES (1, 'Medica', 10, '2019-01-01 00:00:00', '2019-01-01 00:00:00');

COMMIT;


-- -----------------------------------------------------
-- Data for table `patients_lists`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `patients_lists` (`id`, `patients_list_type_id`, `doctor_id`, `create_day_id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES (1, 1, 1, 1, 'Lista 1', '2019-01-01 00:00:00', '2019-01-01 00:00:00', NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `patients`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `patients` (`id`, `patients_list_id`, `doctor_id`, `name`, `surname`, `gender`, `birth_date`, `fiscal_code`, `email`, `phone`, `phone2`, `created_at`, `updated_at`, `deleted_at`, `wrong_number`) VALUES (1, 1, 1, 'Giuseppe', 'Verdi', 'm', '2019-01-01 00:00:00', '1234567890123456', 'giuseppe@verdi.it', '123456', '123456', '2019-01-01 00:00:00', '2019-01-01 00:00:00', NULL, DEFAULT);
INSERT INTO `patients` (`id`, `patients_list_id`, `doctor_id`, `name`, `surname`, `gender`, `birth_date`, `fiscal_code`, `email`, `phone`, `phone2`, `created_at`, `updated_at`, `deleted_at`, `wrong_number`) VALUES (2, 1, 1, 'Anita', 'Garibaldi', 'f', '2019-01-01 00:00:00', '1234567890123456', 'anita@garibaldi.it', '123456', '123456', '2019-01-01 00:00:00', '2019-01-01 00:00:00', NULL, DEFAULT);
INSERT INTO `patients` (`id`, `patients_list_id`, `doctor_id`, `name`, `surname`, `gender`, `birth_date`, `fiscal_code`, `email`, `phone`, `phone2`, `created_at`, `updated_at`, `deleted_at`, `wrong_number`) VALUES (3, 1, 1, 'Il Terzo', 'Incomodo', 'u', '2019-01-01 00:00:00', '1234567890123456', 'ilterzo@incomodo.it', '123456', '123456', '2019-01-01 00:00:00', '2019-01-01 00:00:00', NULL, 1);

COMMIT;


-- -----------------------------------------------------
-- Data for table `doctor_office`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `doctor_office` (`id`, `doctor_id`, `city`, `address`, `cap`, `open_time`, `close_time`) VALUES (1, 1, 'Roma', 'Via dei Mille', '10100', 108, 222);

COMMIT;


-- -----------------------------------------------------
-- Data for table `activity_type`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `activity_type` (`id`, `name`, `description`, `is_health_service`, `show_doctor_calendar`, `is_auto`, `is_survey`) VALUES (1, 'Presa Appuntamento', '', DEFAULT, 1, DEFAULT, DEFAULT);
INSERT INTO `activity_type` (`id`, `name`, `description`, `is_health_service`, `show_doctor_calendar`, `is_auto`, `is_survey`) VALUES (2, 'Telefonata', NULL, DEFAULT, DEFAULT, DEFAULT, DEFAULT);
INSERT INTO `activity_type` (`id`, `name`, `description`, `is_health_service`, `show_doctor_calendar`, `is_auto`, `is_survey`) VALUES (3, 'Appuntamento in studio', NULL, 1, DEFAULT, DEFAULT, DEFAULT);
INSERT INTO `activity_type` (`id`, `name`, `description`, `is_health_service`, `show_doctor_calendar`, `is_auto`, `is_survey`) VALUES (4, 'Email automatica', NULL, DEFAULT, DEFAULT, 1, DEFAULT);
INSERT INTO `activity_type` (`id`, `name`, `description`, `is_health_service`, `show_doctor_calendar`, `is_auto`, `is_survey`) VALUES (5, 'Sondaggio', NULL, DEFAULT, DEFAULT, DEFAULT, 1);

COMMIT;


-- -----------------------------------------------------
-- Data for table `health_service`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `health_service` (`id`, `name`, `id_visitami`) VALUES (1, 'Visita Oculistica', NULL);
INSERT INTO `health_service` (`id`, `name`, `id_visitami`) VALUES (2, 'Visita Audiometrica', NULL);
INSERT INTO `health_service` (`id`, `name`, `id_visitami`) VALUES (3, 'Ecografia Addome', NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `ats`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `ats` (`id`, `name`) VALUES (1, 'ATS di Bergamo');
INSERT INTO `ats` (`id`, `name`) VALUES (2, 'ATS di Brescia');
INSERT INTO `ats` (`id`, `name`) VALUES (3, 'ATS della Brianza');
INSERT INTO `ats` (`id`, `name`) VALUES (4, 'ATS di Città Metropolitana MI');
INSERT INTO `ats` (`id`, `name`) VALUES (5, 'ATS dell\'Insubria');
INSERT INTO `ats` (`id`, `name`) VALUES (6, 'ATS della Montagna');
INSERT INTO `ats` (`id`, `name`) VALUES (7, 'ATS di Pavia');
INSERT INTO `ats` (`id`, `name`) VALUES (8, 'ATS della Valpadana');

COMMIT;


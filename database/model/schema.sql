-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema crm
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema crm
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `crm` DEFAULT CHARACTER SET utf8 ;
USE `crm` ;

-- -----------------------------------------------------
-- Table `crm`.`crm_user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `crm`.`crm_user` (
                                                `id` INT NOT NULL AUTO_INCREMENT,
                                                `first_name` VARCHAR(255) NOT NULL,
    `last_name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `remember_token` VARCHAR(100) NULL,
    `activated` TINYINT NOT NULL DEFAULT 0,
    `forbidden` TINYINT NOT NULL DEFAULT 0,
    `language` VARCHAR(2) NOT NULL DEFAULT 'it',
    `deleted_at` TIMESTAMP NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    `last_login_at` TIMESTAMP NULL,
    `ipfilter` TEXT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `email_UNIQUE` (`email` ASC))
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `crm`.`crm_user_activations`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `crm`.`crm_user_activations` (
    `email` VARCHAR(255) NOT NULL,
    `token` VARCHAR(255) NOT NULL,
    `used` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NULL)
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `crm`.`crm_user_password_resets`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `crm`.`crm_user_password_resets` (
    `email` VARCHAR(255) NOT NULL,
    `token` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NULL)
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `crm`.`roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `crm`.`roles` (
                                             `id` INT NOT NULL AUTO_INCREMENT,
                                             `name` VARCHAR(255) NOT NULL,
    `label` VARCHAR(255) NOT NULL,
    `guard_name` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`))
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `crm`.`permissions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `crm`.`permissions` (
                                                   `id` INT NOT NULL AUTO_INCREMENT,
                                                   `name` VARCHAR(255) NOT NULL,
    `guard_name` VARCHAR(255) NOT NULL,
    `label` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`))
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `crm`.`model_has_permissions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `crm`.`model_has_permissions` (
                                                             `permission_id` INT NOT NULL,
                                                             `model_type` VARCHAR(255) NOT NULL,
    `model_id` INT NOT NULL,
    INDEX `fk_model_has_permissions_permissions_idx` (`permission_id` ASC),
    PRIMARY KEY (`permission_id`, `model_type`, `model_id`),
    INDEX `model_has_permissions_model_id_model_type_index` (`model_type` ASC, `model_id` ASC),
    CONSTRAINT `fk_model_has_permissions_permissions`
    FOREIGN KEY (`permission_id`)
    REFERENCES `crm`.`permissions` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `crm`.`model_has_roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `crm`.`model_has_roles` (
                                                       `role_id` INT NOT NULL,
                                                       `model_type` VARCHAR(255) NOT NULL,
    `model_id` INT NOT NULL,
    INDEX `fk_model_has_roles_roles1_idx` (`role_id` ASC),
    PRIMARY KEY (`role_id`, `model_type`, `model_id`),
    INDEX `model_has_roles_model_id_model_type_index` (`model_type` ASC, `model_id` ASC),
    CONSTRAINT `fk_model_has_roles_roles1`
    FOREIGN KEY (`role_id`)
    REFERENCES `crm`.`roles` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `crm`.`role_has_permissions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `crm`.`role_has_permissions` (
                                                            `role_id` INT NOT NULL,
                                                            `permission_id` INT NOT NULL,
                                                            PRIMARY KEY (`role_id`, `permission_id`),
    INDEX `fk_roles_has_permissions_permissions1_idx` (`permission_id` ASC),
    INDEX `fk_roles_has_permissions_roles1_idx` (`role_id` ASC),
    CONSTRAINT `fk_roles_has_permissions_roles1`
    FOREIGN KEY (`role_id`)
    REFERENCES `crm`.`roles` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    CONSTRAINT `fk_roles_has_permissions_permissions1`
    FOREIGN KEY (`permission_id`)
    REFERENCES `crm`.`permissions` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `crm`.`failed_jobs`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `crm`.`failed_jobs` (
                                                   `id` INT NOT NULL AUTO_INCREMENT,
                                                   `connection` TEXT NOT NULL,
                                                   `queue` TEXT NOT NULL,
                                                   `payload` LONGTEXT NOT NULL,
                                                   `exception` LONGTEXT NOT NULL,
                                                   `failed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                                   PRIMARY KEY (`id`))
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `crm`.`wysiwyg_media`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `crm`.`wysiwyg_media` (
                                                     `id` INT NOT NULL AUTO_INCREMENT,
                                                     `file_path` VARCHAR(255) NOT NULL,
    `wysiwygable_id` INT(10) NULL DEFAULT NULL,
    `wysiwygable_type` VARCHAR(255) NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `wysiwygable_id_UNIQUE` (`wysiwygable_id` ASC))
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `crm`.`migrations`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `crm`.`migrations` (
                                                  `id` INT NOT NULL AUTO_INCREMENT,
                                                  `migration` VARCHAR(255) NOT NULL,
    `batch` INT(11) NOT NULL,
    PRIMARY KEY (`id`))
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `crm`.`translations`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `crm`.`translations` (
                                                    `id` INT NOT NULL AUTO_INCREMENT,
                                                    `namespace` VARCHAR(255) NOT NULL,
    `group` VARCHAR(255) NOT NULL,
    `key` TEXT NOT NULL,
    `text` TEXT NOT NULL,
    `metadata` TEXT NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    `deleted_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`))
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `crm`.`media`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `crm`.`media` (
    `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `uuid` VARCHAR(255) NULL,
    `model_type` VARCHAR(255) NOT NULL,
    `model_id` BIGINT(20) UNSIGNED NOT NULL,
    `collection_name` VARCHAR(255) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `file_name` VARCHAR(255) NOT NULL,
    `mime_type` VARCHAR(255) NULL DEFAULT NULL,
    `disk` VARCHAR(255) NOT NULL,
    `size` BIGINT(20) UNSIGNED NOT NULL,
    `manipulations` TEXT NOT NULL,
    `custom_properties` TEXT NOT NULL,
    `responsive_images` TEXT NOT NULL,
    `order_column` INT(10) UNSIGNED NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    `conversions_disk` VARCHAR(255) NULL,
    PRIMARY KEY (`id`))
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `crm`.`jobs`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `crm`.`jobs` (
    `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `queue` VARCHAR(255) NOT NULL,
    `payload` LONGTEXT NOT NULL,
    `attempts` TINYINT(3) UNSIGNED NOT NULL,
    `reserved_at` INT(10) UNSIGNED NULL DEFAULT NULL,
    `available_at` INT(10) UNSIGNED NOT NULL,
    `created_at` INT(10) UNSIGNED NOT NULL,
    PRIMARY KEY (`id`))
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `crm`.`notifications`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `crm`.`notifications` (
    `id` CHAR(36) NOT NULL,
    `type` VARCHAR(255) NOT NULL,
    `notifiable_type` VARCHAR(255) NOT NULL,
    `notifiable_id` BIGINT(20) UNSIGNED NOT NULL,
    `data` TEXT NOT NULL,
    `read_at` TIMESTAMP NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`))
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `crm`.`esito`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `crm`.`esito` (
                                             `id` INT NOT NULL AUTO_INCREMENT,
                                             `nome` VARCHAR(255) NOT NULL,
    `cod` INT NULL,
    `is_final` TINYINT(1) NOT NULL DEFAULT 0,
    `is_new` TINYINT(1) NOT NULL DEFAULT 0,
    `is_ok` TINYINT(1) NOT NULL DEFAULT 0,
    `is_recover` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    `deleted_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`))
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `crm`.`campagna`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `crm`.`campagna` (
                                                `id` INT NOT NULL AUTO_INCREMENT,
                                                `nome` VARCHAR(255) NOT NULL,
    `tipo` VARCHAR(45) NOT NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    `deleted_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`))
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `crm`.`partner`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `crm`.`partner` (
                                               `id` INT NOT NULL AUTO_INCREMENT,
                                               `nome` VARCHAR(255) NOT NULL,
    `vc_usergroup` VARCHAR(45) NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    `deleted_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`))
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `crm`.`crm_user_has_partner`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `crm`.`crm_user_has_partner` (
                                                            `crm_user` INT NOT NULL,
                                                            `partner` INT NOT NULL,
                                                            PRIMARY KEY (`crm_user`, `partner`),
    INDEX `fk_crm_user_has_partner_partner1_idx` (`partner` ASC),
    INDEX `fk_crm_user_has_partner_crm_user1_idx` (`crm_user` ASC),
    CONSTRAINT `fk_crm_user_has_partner_crm_user1`
    FOREIGN KEY (`crm_user`)
    REFERENCES `crm`.`crm_user` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
    CONSTRAINT `fk_crm_user_has_partner_partner1`
    FOREIGN KEY (`partner`)
    REFERENCES `crm`.`partner` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `crm`.`crm_user_has_campagna`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `crm`.`crm_user_has_campagna` (
                                                             `crm_user` INT NOT NULL,
                                                             `campagna` INT NOT NULL,
                                                             PRIMARY KEY (`crm_user`, `campagna`),
    INDEX `fk_crm_user_has_campagna_campagna1_idx` (`campagna` ASC),
    INDEX `fk_crm_user_has_campagna_crm_user1_idx` (`crm_user` ASC),
    CONSTRAINT `fk_crm_user_has_campagna_crm_user1`
    FOREIGN KEY (`crm_user`)
    REFERENCES `crm`.`crm_user` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
    CONSTRAINT `fk_crm_user_has_campagna_campagna1`
    FOREIGN KEY (`campagna`)
    REFERENCES `crm`.`campagna` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `crm`.`partner_has_campagna`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `crm`.`partner_has_campagna` (
                                                            `partner` INT NOT NULL,
                                                            `campagna` INT NOT NULL,
                                                            PRIMARY KEY (`partner`, `campagna`),
    INDEX `fk_partner_has_campagna_campagna1_idx` (`campagna` ASC),
    INDEX `fk_partner_has_campagna_partner1_idx` (`partner` ASC),
    CONSTRAINT `fk_partner_has_campagna_partner1`
    FOREIGN KEY (`partner`)
    REFERENCES `crm`.`partner` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
    CONSTRAINT `fk_partner_has_campagna_campagna1`
    FOREIGN KEY (`campagna`)
    REFERENCES `crm`.`campagna` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `crm`.`dati_contratto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `crm`.`dati_contratto` (
                                                      `id` INT NOT NULL AUTO_INCREMENT,
                                                      `campagna` INT NOT NULL,
                                                      `crm_user` INT NULL,
                                                      `update_user` INT NULL,
                                                      `partner` INT NULL,
                                                      `codice_pratica` VARCHAR(255) NULL,
    `tipo_inserimento` VARCHAR(45) NOT NULL,
    `tipo_offerta` VARCHAR(45) NOT NULL,
    `tipo_contratto` VARCHAR(45) NOT NULL,
    `owner_nome` VARCHAR(255) NOT NULL,
    `owner_cognome` VARCHAR(255) NOT NULL,
    `owner_dob` VARCHAR(10) NOT NULL,
    `owner_pob` VARCHAR(255) NOT NULL,
    `owner_cf` VARCHAR(16) NULL,
    `owner_tipo_doc` VARCHAR(45) NOT NULL,
    `owner_nr_doc` VARCHAR(45) NOT NULL,
    `owner_ente_doc` VARCHAR(255) NOT NULL,
    `owner_doc_data` VARCHAR(10) NOT NULL,
    `owner_doc_scadenza` VARCHAR(10) NOT NULL,
    `owner_piva` VARCHAR(11) NULL,
    `owner_rag_soc` VARCHAR(255) NULL,
    `owner_email` VARCHAR(255) NULL,
    `telefono` VARCHAR(20) NOT NULL,
    `cellulare` VARCHAR(20) NULL,
    `owner_indirizzo` VARCHAR(255) NOT NULL,
    `owner_civico` VARCHAR(10) NOT NULL,
    `owner_comune` VARCHAR(255) NOT NULL,
    `owner_prov` VARCHAR(2) NOT NULL,
    `owner_cap` VARCHAR(5) NOT NULL,
    `owner_az_nome_societa` VARCHAR(255) NULL,
    `owner_az_codice_business` VARCHAR(255) NULL,
    `owner_az_comune` VARCHAR(255) NULL,
    `owner_az_prov` VARCHAR(2) NULL,
    `owner_az_cap` VARCHAR(5) NULL,
    `forn_indirizzo` VARCHAR(255) NOT NULL,
    `forn_civico` VARCHAR(10) NOT NULL,
    `forn_comune` VARCHAR(255) NOT NULL,
    `forn_prov` VARCHAR(2) NOT NULL,
    `forn_cap` VARCHAR(5) NOT NULL,
    `fatt_indirizzo` VARCHAR(255) NULL,
    `fatt_civico` VARCHAR(10) NULL,
    `fatt_comune` VARCHAR(255) NULL,
    `fatt_prov` VARCHAR(2) NULL,
    `fatt_cap` VARCHAR(5) NULL,
    `mod_pagamento` VARCHAR(45) NOT NULL,
    `sdd_iban` VARCHAR(27) NULL,
    `sdd_ente` VARCHAR(255) NULL,
    `sdd_intestatario` VARCHAR(255) NULL,
    `sdd_cf` VARCHAR(45) NULL,
    `delega` TINYINT(1) NOT NULL DEFAULT 0,
    `delega_nome` VARCHAR(100) NULL,
    `delega_cognome` VARCHAR(100) NULL,
    `delega_dob` VARCHAR(10) NULL,
    `delega_pob` VARCHAR(255) NULL,
    `delega_cf` VARCHAR(45) NULL,
    `delega_tipo_doc` VARCHAR(45) NULL,
    `delega_nr_doc` VARCHAR(45) NULL,
    `delega_ente_doc` VARCHAR(255) NULL,
    `delega_doc_data` VARCHAR(10) NULL,
    `delega_doc_scadenza` VARCHAR(10) NULL,
    `delega_tipo_rapporto` VARCHAR(100) NULL,
    `titolarita_immobile` VARCHAR(45) NULL,
    `luce_polizza` TINYINT(1) NOT NULL DEFAULT 0,
    `luce_pod` VARCHAR(45) NULL,
    `luce_kw` VARCHAR(45) NULL,
    `luce_tensione` VARCHAR(45) NULL,
    `luce_consumo` VARCHAR(45) NULL,
    `luce_fornitore` VARCHAR(100) NULL,
    `luce_mercato` VARCHAR(45) NULL,
    `gas_polizza` TINYINT(1) NOT NULL DEFAULT 0,
    `gas_polizza_caldaia` TINYINT(1) NOT NULL DEFAULT 0,
    `gas_pdr` VARCHAR(45) NULL,
    `gas_consumo` VARCHAR(45) NULL,
    `gas_fornitore` VARCHAR(100) NULL,
    `gas_matricola` VARCHAR(45) NULL,
    `gas_remi` VARCHAR(45) NULL,
    `gas_mercato` VARCHAR(45) NULL,
    `tel_offerta` VARCHAR(255) NULL,
    `tel_cod_mig_voce` VARCHAR(255) NULL,
    `tel_cod_mig_adsl` VARCHAR(255) NULL,
    `tel_cellulare_assoc` VARCHAR(20) NULL,
    `tel_fornitore` VARCHAR(100) NULL,
    `tel_tipo_linea` VARCHAR(255) NULL,
    `tel_iccd` VARCHAR(255) NULL,
    `tel_scadenza_telecom` VARCHAR(255) NULL,
    `note_ope` TEXT NULL,
    `note_bo` TEXT NULL,
    `note_sv` TEXT NULL,
    `note_verifica` TEXT NULL,
    `esito` INT NOT NULL,
    `id_rec` INT NULL,
    `tipo_fatturazione` VARCHAR(45) NOT NULL,
    `tipo_fatturazione_email` VARCHAR(255) NULL,
    `tipo_fatturazione_cartaceo` VARCHAR(255) NULL,
    `fascia_reperibilita` VARCHAR(45) NOT NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    `deleted_at` TIMESTAMP NULL,
    `recall_at` TIMESTAMP NULL,
    `recover_at` TIMESTAMP NULL,
    `lista` VARCHAR(255) NULL,
    `tel_tipo_passaggio` VARCHAR(255) NULL,
    `tel_passaggio_numero` VARCHAR(255) NULL,
    `tel_finanziamento` TINYINT(1) NOT NULL DEFAULT 0,
    `tel_canone` VARCHAR(45) NULL,
    `tel_sell_smartphone` TINYINT(1) NOT NULL DEFAULT 0,
    `tel_gia_cliente` TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`),
    INDEX `fk_contract_crm_user1_idx` (`crm_user` ASC),
    INDEX `fk_contract_partner1_idx` (`partner` ASC),
    INDEX `fk_contract_esito1_idx` (`esito` ASC),
    INDEX `fk_contract_campagna1_idx` (`campagna` ASC),
    INDEX `fk_dati_contratto_crm_user1_idx` (`update_user` ASC),
    INDEX `index_fast_search` (`tipo_inserimento` ASC, `codice_pratica` ASC),
    CONSTRAINT `fk_contract_crm_user1`
    FOREIGN KEY (`crm_user`)
    REFERENCES `crm`.`crm_user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
    CONSTRAINT `fk_contract_partner1`
    FOREIGN KEY (`partner`)
    REFERENCES `crm`.`partner` (`id`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
    CONSTRAINT `fk_contract_esito1`
    FOREIGN KEY (`esito`)
    REFERENCES `crm`.`esito` (`id`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
    CONSTRAINT `fk_contract_campagna1`
    FOREIGN KEY (`campagna`)
    REFERENCES `crm`.`campagna` (`id`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
    CONSTRAINT `fk_dati_contratto_crm_user1`
    FOREIGN KEY (`update_user`)
    REFERENCES `crm`.`crm_user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `crm`.`recording_log`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `crm`.`recording_log` (
    `recording_id` INT(10) NOT NULL AUTO_INCREMENT,
    `channel` VARCHAR(100) NULL,
    `server_ip` VARCHAR(15) NULL,
    `extension` VARCHAR(100) NULL,
    `start_time` DATETIME NULL,
    `start_epoch` INT(10) NULL,
    `end_time` DATETIME NULL,
    `end_epoch` INT(10) NULL,
    `length_in_sec` MEDIUMINT(8) NULL,
    `length_in_min` DOUBLE(8,2) NULL,
    `filename` VARCHAR(100) NULL,
    `location` VARCHAR(255) NULL,
    `lead_id` INT(9) NULL,
    `user` VARCHAR(20) NULL,
    `vicidial_id` VARCHAR(20) NULL,
    PRIMARY KEY (`recording_id`))
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `crm`.`sys_settings`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `crm`.`sys_settings` (
                                                    `id` INT NOT NULL AUTO_INCREMENT,
                                                    `crm_user` INT NULL,
                                                    `key` VARCHAR(255) NOT NULL,
    `value` TEXT NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `fk_sys_settings_crm_user1_idx` (`crm_user` ASC),
    UNIQUE INDEX `crm_user_key_UNIQUE` (`crm_user` ASC, `key` ASC),
    CONSTRAINT `fk_sys_settings_crm_user1`
    FOREIGN KEY (`crm_user`)
    REFERENCES `crm`.`crm_user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `crm`.`rec_server`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `crm`.`rec_server` (
                                                  `id` INT NOT NULL AUTO_INCREMENT,
                                                  `name` VARCHAR(255) NOT NULL,
    `type` VARCHAR(45) NOT NULL,
    `db_driver` VARCHAR(45) NOT NULL,
    `db_host` VARCHAR(255) NOT NULL,
    `db_port` VARCHAR(10) NOT NULL,
    `db_name` VARCHAR(255) NOT NULL,
    `db_user` VARCHAR(45) NOT NULL,
    `db_password` VARCHAR(45) NOT NULL,
    `db_rewrite_host` TINYINT(1) NOT NULL DEFAULT 0,
    `db_rewrite_search` VARCHAR(255) NULL,
    `db_rewrite_replace` VARCHAR(255) NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    `deleted_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`))
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `crm`.`vicidial_agent_log`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `crm`.`vicidial_agent_log` (
    `agent_log_id` INT(10) NOT NULL AUTO_INCREMENT,
    `user` VARCHAR(20) NULL DEFAULT NULL,
    `server_ip` VARCHAR(15) NOT NULL,
    `event_time` DATETIME NULL DEFAULT NULL,
    `campaign_id` VARCHAR(8) NULL DEFAULT NULL,
    `pause_sec` SMALLINT(5) UNSIGNED NULL DEFAULT 0,
    `wait_sec` SMALLINT(5) UNSIGNED NULL DEFAULT 0,
    `talk_sec` SMALLINT(5) UNSIGNED NULL DEFAULT 0,
    `dispo_sec` SMALLINT(5) UNSIGNED NULL DEFAULT 0,
    `status` VARCHAR(6) NULL DEFAULT NULL,
    `user_group` VARCHAR(20) NULL DEFAULT NULL,
    `dead_sec` SMALLINT(5) UNSIGNED NULL DEFAULT 0,
    `uniqueid` VARCHAR(20) NULL DEFAULT '',
    `pause_type` ENUM('UNDEFINED', 'SYSTEM', 'AGENT', 'API', 'ADMIN') NULL DEFAULT 'UNDEFINED',
    PRIMARY KEY (`agent_log_id`))
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `crm`.`vicidial_users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `crm`.`vicidial_users` (
    `user_id` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT,
    `user` VARCHAR(20) NOT NULL,
    `pass` VARCHAR(100) NOT NULL,
    `full_name` VARCHAR(50) NULL DEFAULT NULL,
    `user_level` TINYINT(3) UNSIGNED NULL DEFAULT 1,
    `user_group` VARCHAR(20) NULL DEFAULT NULL,
    `phone_login` VARCHAR(20) NULL DEFAULT NULL,
    `phone_pass` VARCHAR(100) NULL DEFAULT NULL,
    `delete_users` ENUM('0', '1') NULL DEFAULT '0',
    `delete_user_groups` ENUM('0', '1') NULL DEFAULT '0',
    `delete_lists` ENUM('0', '1') NULL DEFAULT '0',
    `delete_campaigns` ENUM('0', '1') NULL DEFAULT '0',
    `delete_ingroups` ENUM('0', '1') NULL DEFAULT '0',
    `delete_remote_agents` ENUM('0', '1') NULL DEFAULT '0',
    `load_leads` ENUM('0', '1') NULL DEFAULT '0',
    `campaign_detail` ENUM('0', '1') NULL DEFAULT '0',
    `ast_admin_access` ENUM('0', '1') NULL DEFAULT '0',
    `ast_delete_phones` ENUM('0', '1') NULL DEFAULT '0',
    `delete_scripts` ENUM('0', '1') NULL DEFAULT '0',
    `modify_leads` ENUM('0', '1', '2', '3', '4', '5', '6') NULL DEFAULT '0',
    `hotkeys_active` ENUM('0', '1') NULL DEFAULT '0',
    `change_agent_campaign` ENUM('0', '1') NULL DEFAULT '0',
    `agent_choose_ingroups` ENUM('0', '1') NULL DEFAULT '1',
    `closer_campaigns` TEXT NULL DEFAULT NULL,
    `scheduled_callbacks` ENUM('0', '1') NULL DEFAULT '1',
    `agentonly_callbacks` ENUM('0', '1') NULL DEFAULT '0',
    `agentcall_manual` ENUM('0', '1', '2', '3', '4', '5') NULL DEFAULT '0',
    `vicidial_recording` ENUM('0', '1') NULL DEFAULT '1',
    `vicidial_transfers` ENUM('0', '1') NULL DEFAULT '1',
    `delete_filters` ENUM('0', '1') NULL DEFAULT '0',
    `alter_agent_interface_options` ENUM('0', '1') NULL DEFAULT '0',
    `closer_default_blended` ENUM('0', '1') NULL DEFAULT '0',
    `delete_call_times` ENUM('0', '1') NULL DEFAULT '0',
    `modify_call_times` ENUM('0', '1') NULL DEFAULT '0',
    `modify_users` ENUM('0', '1') NULL DEFAULT '0',
    `modify_campaigns` ENUM('0', '1') NULL DEFAULT '0',
    `modify_lists` ENUM('0', '1') NULL DEFAULT '0',
    `modify_scripts` ENUM('0', '1') NULL DEFAULT '0',
    `modify_filters` ENUM('0', '1') NULL DEFAULT '0',
    `modify_ingroups` ENUM('0', '1') NULL DEFAULT '0',
    `modify_usergroups` ENUM('0', '1') NULL DEFAULT '0',
    `modify_remoteagents` ENUM('0', '1') NULL DEFAULT '0',
    `modify_servers` ENUM('0', '1') NULL DEFAULT '0',
    `view_reports` ENUM('0', '1') NULL DEFAULT '0',
    `vicidial_recording_override` ENUM('DISABLED', 'NEVER', 'ONDEMAND', 'ALLCALLS', 'ALLFORCE') NULL DEFAULT 'DISABLED',
    `alter_custdata_override` ENUM('NOT_ACTIVE', 'ALLOW_ALTER') NULL DEFAULT 'NOT_ACTIVE',
    `qc_enabled` ENUM('0', '1') NULL DEFAULT '0',
    `qc_user_level` INT(2) NULL DEFAULT 1,
    `qc_pass` ENUM('0', '1') NULL DEFAULT '0',
    `qc_finish` ENUM('0', '1') NULL DEFAULT '0',
    `qc_commit` ENUM('0', '1') NULL DEFAULT '0',
    `add_timeclock_log` ENUM('0', '1') NULL DEFAULT '0',
    `modify_timeclock_log` ENUM('0', '1') NULL DEFAULT '0',
    `delete_timeclock_log` ENUM('0', '1') NULL DEFAULT '0',
    `alter_custphone_override` ENUM('NOT_ACTIVE', 'ALLOW_ALTER') NULL DEFAULT 'NOT_ACTIVE',
    `vdc_agent_api_access` ENUM('0', '1') NULL DEFAULT '0',
    `modify_inbound_dids` ENUM('0', '1') NULL DEFAULT '0',
    `delete_inbound_dids` ENUM('0', '1') NULL DEFAULT '0',
    `active` ENUM('Y', 'N') NULL DEFAULT 'Y',
    `alert_enabled` ENUM('0', '1') NULL DEFAULT '0',
    `download_lists` ENUM('0', '1') NULL DEFAULT '0',
    `agent_shift_enforcement_override` ENUM('DISABLED', 'OFF', 'START', 'ALL') NULL DEFAULT 'DISABLED',
    `manager_shift_enforcement_override` ENUM('0', '1') NULL DEFAULT '0',
    `shift_override_flag` ENUM('0', '1') NULL DEFAULT '0',
    `export_reports` ENUM('0', '1') NULL DEFAULT '0',
    `delete_from_dnc` ENUM('0', '1') NULL DEFAULT '0',
    `email` VARCHAR(100) NULL DEFAULT '',
    `user_code` VARCHAR(100) NULL DEFAULT '',
    `territory` VARCHAR(100) NULL DEFAULT '',
    `allow_alerts` ENUM('0', '1') NULL DEFAULT '0',
    `agent_choose_territories` ENUM('0', '1') NULL DEFAULT '1',
    `custom_one` VARCHAR(100) NULL DEFAULT '',
    `custom_two` VARCHAR(100) NULL DEFAULT '',
    `custom_three` VARCHAR(100) NULL DEFAULT '',
    `custom_four` VARCHAR(100) NULL DEFAULT '',
    `custom_five` VARCHAR(100) NULL DEFAULT '',
    `voicemail_id` VARCHAR(10) NULL DEFAULT NULL,
    `agent_call_log_view_override` ENUM('DISABLED', 'Y', 'N') NULL DEFAULT 'DISABLED',
    `callcard_admin` ENUM('1', '0') NULL DEFAULT '0',
    `agent_choose_blended` ENUM('0', '1') NULL DEFAULT '1',
    `realtime_block_user_info` ENUM('0', '1') NULL DEFAULT '0',
    `custom_fields_modify` ENUM('0', '1') NULL DEFAULT '0',
    `force_change_password` ENUM('Y', 'N') NULL DEFAULT 'N',
    `agent_lead_search_override` ENUM('NOT_ACTIVE', 'ENABLED', 'LIVE_CALL_INBOUND', 'LIVE_CALL_INBOUND_AND_MANUAL', 'DISABLED') NULL DEFAULT 'NOT_ACTIVE',
    `modify_shifts` ENUM('1', '0') NULL DEFAULT '0',
    `modify_phones` ENUM('1', '0') NULL DEFAULT '0',
    `modify_carriers` ENUM('1', '0') NULL DEFAULT '0',
    `modify_labels` ENUM('1', '0') NULL DEFAULT '0',
    `modify_statuses` ENUM('1', '0') NULL DEFAULT '0',
    `modify_voicemail` ENUM('1', '0') NULL DEFAULT '0',
    `modify_audiostore` ENUM('1', '0') NULL DEFAULT '0',
    `modify_moh` ENUM('1', '0') NULL DEFAULT '0',
    `modify_tts` ENUM('1', '0') NULL DEFAULT '0',
    `preset_contact_search` ENUM('NOT_ACTIVE', 'ENABLED', 'DISABLED') NULL DEFAULT 'NOT_ACTIVE',
    `modify_contacts` ENUM('1', '0') NULL DEFAULT '0',
    `modify_same_user_level` ENUM('0', '1') NULL DEFAULT '1',
    `admin_hide_lead_data` ENUM('0', '1') NULL DEFAULT '0',
    `admin_hide_phone_data` ENUM('0', '1', '2_DIGITS', '3_DIGITS', '4_DIGITS') NULL DEFAULT '0',
    `agentcall_email` ENUM('0', '1') NULL DEFAULT '0',
    `modify_email_accounts` ENUM('0', '1') NULL DEFAULT '0',
    `failed_login_count` TINYINT(3) UNSIGNED NULL DEFAULT 0,
    `last_login_date` DATETIME NULL DEFAULT '2001-01-01 00:00:01',
    `last_ip` VARCHAR(15) NULL DEFAULT '',
    `pass_hash` VARCHAR(500) NULL DEFAULT '',
    `alter_admin_interface_options` ENUM('0', '1') NULL DEFAULT '1',
    `max_inbound_calls` SMALLINT(5) UNSIGNED NULL DEFAULT 0,
    `modify_custom_dialplans` ENUM('1', '0') NULL DEFAULT '0',
    `wrapup_seconds_override` SMALLINT(4) NULL DEFAULT -1,
    `modify_languages` ENUM('1', '0') NULL DEFAULT '0',
    `selected_language` VARCHAR(100) NULL DEFAULT 'default English',
    `user_choose_language` ENUM('1', '0') NULL DEFAULT '0',
    `ignore_group_on_search` ENUM('1', '0') NULL DEFAULT '0',
    `api_list_restrict` ENUM('1', '0') NULL DEFAULT '0',
    `api_allowed_functions` VARCHAR(1000) NULL DEFAULT ' ALL_FUNCTIONS ',
    `lead_filter_id` VARCHAR(20) NULL DEFAULT 'NONE',
    `admin_cf_show_hidden` ENUM('1', '0') NULL DEFAULT '0',
    `agentcall_chat` ENUM('1', '0') NULL DEFAULT '0',
    `user_hide_realtime` ENUM('1', '0') NULL DEFAULT '0',
    `access_recordings` ENUM('0', '1') NULL DEFAULT '0',
    `modify_colors` ENUM('1', '0') NULL DEFAULT '0',
    `user_nickname` VARCHAR(50) NULL DEFAULT '',
    `user_new_lead_limit` SMALLINT(5) NULL DEFAULT -1,
    `api_only_user` ENUM('0', '1') NULL DEFAULT '0',
    `modify_auto_reports` ENUM('1', '0') NULL DEFAULT '0',
    `modify_ip_lists` ENUM('1', '0') NULL DEFAULT '0',
    `ignore_ip_list` ENUM('1', '0') NULL DEFAULT '0',
    `ready_max_logout` MEDIUMINT(7) NULL DEFAULT -1,
    `export_gdpr_leads` ENUM('0', '1', '2') NULL DEFAULT '0',
    `pause_code_approval` ENUM('1', '0') NULL DEFAULT '0',
    `max_hopper_calls` SMALLINT(5) UNSIGNED NULL DEFAULT 0,
    `max_hopper_calls_hour` SMALLINT(5) UNSIGNED NULL DEFAULT 0,
    `mute_recordings` ENUM('DISABLED', 'Y', 'N') NULL DEFAULT 'DISABLED',
    `hide_call_log_info` ENUM('DISABLED', 'Y', 'N', 'SHOW_1', 'SHOW_2', 'SHOW_3', 'SHOW_4', 'SHOW_5', 'SHOW_6', 'SHOW_7', 'SHOW_8', 'SHOW_9', 'SHOW_10') NULL DEFAULT 'DISABLED',
    `next_dial_my_callbacks` ENUM('NOT_ACTIVE', 'DISABLED', 'ENABLED') NULL DEFAULT 'NOT_ACTIVE',
    `user_admin_redirect_url` TEXT NULL DEFAULT NULL,
    `max_inbound_filter_enabled` ENUM('0', '1') NULL DEFAULT '0',
    `max_inbound_filter_statuses` TEXT NULL DEFAULT NULL,
    `max_inbound_filter_ingroups` TEXT NULL DEFAULT NULL,
    `max_inbound_filter_min_sec` SMALLINT(5) NULL DEFAULT -1,
    `status_group_id` VARCHAR(20) NULL DEFAULT '',
    `mobile_number` VARCHAR(20) NULL DEFAULT '',
    `two_factor_override` ENUM('NOT_ACTIVE', 'ENABLED', 'DISABLED') NULL DEFAULT 'NOT_ACTIVE',
    PRIMARY KEY (`user_id`))
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `crm`.`user_timelog`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `crm`.`user_timelog` (
                                                    `id` INT NOT NULL AUTO_INCREMENT,
                                                    `ore` DECIMAL(10,2) NOT NULL DEFAULT 0,
    `minuti` INT NOT NULL DEFAULT 0,
    `user` INT NOT NULL,
    `campagna` INT NULL,
    `period` DATE NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `fk_user_timelog_crm_user1_idx` (`user` ASC),
    INDEX `fk_user_timelog_campagna1_idx` (`campagna` ASC),
    CONSTRAINT `fk_user_timelog_crm_user1`
    FOREIGN KEY (`user`)
    REFERENCES `crm`.`crm_user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    CONSTRAINT `fk_user_timelog_campagna1`
    FOREIGN KEY (`campagna`)
    REFERENCES `crm`.`campagna` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
    ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

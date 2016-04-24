DROP INDEX `supervisors_email_unique` ON `supervisors`;

ALTER TABLE `supervisors` 
  ADD UNIQUE KEY `supervisors_email_unique` (`user_id`, `email`);

DELIMITER //
CREATE FUNCTION IsEmailUniqueCheck (p_email VARCHAR(255) , p_client_id INT) 
RETURNS int
BEGIN
  DECLARE v_user_id INT;
  DECLARE v_cnt INT;
  
  SELECT DISTINCT user_id INTO v_user_id
  FROM services S, client_service CS
  WHERE S.id = CS.service_id AND
        CS.client_id = p_client_id;

  SELECT COUNT(*) INTO v_cnt 
  FROM clients C1 
  WHERE C1.id <> p_client_id AND
        C1.email = p_email AND
        C1.id in (SELECT CS.client_id
                  FROM client_service CS, services S
                  WHERE CS.service_id = S.id AND
                        S.user_id = v_user_id);
  RETURN v_cnt;
END //

DELIMITER //
CREATE TRIGGER trg_clients_bi_email_unique
BEFORE INSERT ON clients
FOR EACH ROW
BEGIN
  DECLARE res INT;
  DECLARE msg VARCHAR(255);
  SELECT IsEmailUniqueCheck(NEW.email, NEW.id) INTO res;
  IF res > 0 THEN
    set msg = concat('ClientEmailError: Trying to insert duplicite email: ', NEW.email);
        signal sqlstate '99999' set message_text = msg;
  END IF;
END //

DELIMITER //
CREATE TRIGGER trg_clients_bu_email_unique
BEFORE UPDATE ON clients
FOR EACH ROW
BEGIN
  DECLARE res INT;
  DECLARE msg VARCHAR(255);
  SELECT IsEmailUniqueCheck(NEW.email, NEW.id) INTO res;
  IF res > 0 THEN
    set msg = concat('ClientEmailError: Trying to insert duplicite email: ', NEW.email);
        signal sqlstate '99999' set message_text = msg;
  END IF;
END //

DELIMITER //
CREATE TRIGGER trg_client_service_bi_email_unique
BEFORE INSERT ON client_service
FOR EACH ROW
BEGIN
  DECLARE v_email VARCHAR(255);
  DECLARE res INT;
  DECLARE msg VARCHAR(255);
  
  
  SELECT DISTINCT email INTO v_email
  FROM clients
  WHERE id = NEW.client_id;

  SELECT IsEmailUniqueCheck(v_email, NEW.client_id) INTO res;
  IF res > 0 THEN
    set msg = concat('ClientEmailError: Trying to insert duplicite email: ', v_email);
        signal sqlstate '99999' set message_text = msg;
  END IF;
END //

DELIMITER //
CREATE TRIGGER trg_client_service_bu_email_unique
BEFORE UPDATE ON client_service
FOR EACH ROW
BEGIN
  DECLARE v_email VARCHAR(255);
  DECLARE res INT;
  DECLARE msg VARCHAR(255);
  
  SELECT DISTINCT email INTO v_email
  FROM clients
  WHERE id = NEW.client_id;

  SELECT IsEmailUniqueCheck(v_email, NEW.client_id) INTO res;
  IF res > 0 THEN
    set msg = concat('ClientEmailError: Trying to insert duplicite email: ', v_email);
        signal sqlstate '99999' set message_text = msg;
  END IF;
END //

DELIMITER ;
CREATE TABLE `chat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `report_id` int(10) unsigned NOT NULL,
  `technician_id` int(10) unsigned NULL,
  `supervisor_id` int(10) unsigned NULL,
  `client_id` int(10) unsigned NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `chat_id_parent` int(10) unsigned NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY `pk_chat` (`id`),
  KEY `chat_report_id_index` (`report_id`),
  KEY `chat_technician_id_index` (`technician_id`),
  KEY `chat_supervisor_id_index` (`supervisor_id`),
  KEY `chat_client_id_index` (`client_id`),
  KEY `chat_chat_id_parent_index` (`chat_id_parent`),
  CONSTRAINT `chat_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  CONSTRAINT `chat_technician_id_foreign` FOREIGN KEY (`technician_id`) REFERENCES `technicians` (`id`),
  CONSTRAINT `chat_supervisor_id_foreign` FOREIGN KEY (`supervisor_id`) REFERENCES `supervisors` (`id`),
  CONSTRAINT `chat_report_id_foreign` FOREIGN KEY (`report_id`) REFERENCES `reports` (`id`),
  CONSTRAINT `chat_chat_id_parent_foreign` FOREIGN KEY (`chat_id_parent`) REFERENCES `chat` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DELIMITER //
DROP TRIGGER IF EXISTS trg_chat_bi_author//
CREATE TRIGGER trg_chat_bi_author
BEFORE INSERT ON chat
FOR EACH ROW
BEGIN
  DECLARE msg VARCHAR(255);
  IF CASE
       WHEN NEW.technician_id IS NULL THEN 0 
       ELSE 1
     END + 
     CASE
       WHEN NEW.supervisor_id IS NULL THEN 0 
       ELSE 1
     END +
     CASE
       WHEN NEW.client_id IS NULL THEN 0 
       ELSE 1
     END <> 1 THEN
    set msg = concat('ChatAuthorError: Just one Client/Technician/Supervisor must be filled');
        signal sqlstate '99998' set message_text = msg;
  END IF;
END //

DELIMITER ;
CREATE TABLE `images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `report_id` int(10) unsigned NULL,
  `technician_id` int(10) unsigned NULL,
  `supervisor_id` int(10) unsigned NULL,
  `client_id` int(10) unsigned NULL,
  `service_id` int(10) unsigned NULL,
  `image` varchar(255) NOT NULL,
  `image_type` char(1) NOT NULL DEFAULT 'N',
  `image_order` smallint NOT NULL DEFAULT 1, 
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY `pk_images` (`id`),
  KEY `images_report_id_index` (`report_id`),
  KEY `images_technician_id_index` (`technician_id`),
  KEY `images_supervisor_id_index` (`supervisor_id`),
  KEY `images_client_id_index` (`client_id`),
  KEY `images_service_id_index` (`service_id`),
  CONSTRAINT `images_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  CONSTRAINT `images_technician_id_foreign` FOREIGN KEY (`technician_id`) REFERENCES `technicians` (`id`),
  CONSTRAINT `images_supervisor_id_foreign` FOREIGN KEY (`supervisor_id`) REFERENCES `supervisors` (`id`),
  CONSTRAINT `images_report_id_foreign` FOREIGN KEY (`report_id`) REFERENCES `reports` (`id`),
  CONSTRAINT `images_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DELIMITER //
DROP TRIGGER IF EXISTS trg_images_bi_source//
CREATE TRIGGER trg_images_bi_source
BEFORE INSERT ON images
FOR EACH ROW
BEGIN
  DECLARE msg VARCHAR(255);
  IF CASE
       WHEN NEW.technician_id IS NULL THEN 0 
       ELSE 1
     END + 
     CASE
       WHEN NEW.supervisor_id IS NULL THEN 0 
       ELSE 1
     END +
     CASE
       WHEN NEW.client_id IS NULL THEN 0 
       ELSE 1
     END +
     CASE
       WHEN NEW.service_id IS NULL THEN 0 
       ELSE 1
     END +
     CASE
       WHEN NEW.report_id IS NULL THEN 0 
       ELSE 1
     END <> 1 THEN
    set msg = concat('ImageSourceError: Just one Client/Technician/Supervisor/Service/Report must be filled');
        signal sqlstate '99997' set message_text = msg;
  END IF;
END //

DELIMITER ;
insert into images (report_id,  technician_id, supervisor_id,
                    client_id, service_id, image,
                    image_type, image_order, 
                    created_at, updated_at, deleted_at)
  select id, NULL, NULL, NULL, NULL, image_1, 'N', 1, created_at, updated_at, deleted_at
  from reports
  where image_1 is not null
  union all
  select id, NULL, NULL, NULL, NULL, image_2, 'N', 2, created_at, updated_at, deleted_at
  from reports
  where image_2 is not null
  union all
  select id, NULL, NULL, NULL, NULL, image_3, 'N', 3, created_at, updated_at, deleted_at
  from reports
  where image_3 is not null
  union all
  select id, NULL, NULL, NULL, NULL, tn_image_1, 'T', 1, created_at, updated_at, deleted_at
  from reports
  where tn_image_1 is not null
  union all
  select id, NULL, NULL, NULL, NULL, tn_image_2, 'T', 2, created_at, updated_at, deleted_at
  from reports
  where tn_image_2 is not null
  union all
  select id, NULL, NULL, NULL, NULL, tn_image_3, 'T', 1, created_at, updated_at, deleted_at
  from reports
  where tn_image_3 is not null
  union all
  select NULL, id, NULL, NULL, NULL, image, 'N', 1, created_at, updated_at, deleted_at
  from technicians
  where image is not null
  union all
  select NULL, id, NULL, NULL, NULL, tn_image, 'T', 1, created_at, updated_at, deleted_at
  from technicians
  where tn_image is not null
  union all
  select NULL, NULL, id, NULL, NULL, image, 'N', 1, created_at, updated_at, deleted_at
  from supervisors
  where image is not null
  union all
  select NULL, NULL, id, NULL, NULL, tn_image, 'T', 1, created_at, updated_at, deleted_at
  from supervisors
  where tn_image is not null
  union all
  select NULL, NULL, NULL, id, NULL, image, 'N', 1, created_at, updated_at, deleted_at
  from clients
  where image is not null
  union all
  select NULL, NULL, NULL, id, NULL, tn_image, 'T', 1, created_at, updated_at, deleted_at
  from clients
  where tn_image is not null
  union all
  select NULL, NULL, NULL, NULL, id, image, 'N', 1, created_at, updated_at, deleted_at
  from services
  where image is not null
  union all
  select NULL, NULL, NULL, NULL, id, tn_image, 'T', 1, created_at, updated_at, deleted_at
  from services
  where tn_image is not null;

alter table clients
  drop column image;

alter table clients
  drop column tn_image;

alter table services
  drop column image;

alter table services
  drop column tn_image;

alter table supervisors
  drop column image;

alter table supervisors
  drop column tn_image;

alter table technicians
  drop column image;

alter table technicians
  drop column tn_image;

alter table reports
  drop column image_1;

alter table reports
  drop column tn_image_1;

alter table reports
  drop column image_2;

alter table reports
  drop column tn_image_2;

alter table reports
  drop column image_3;

alter table reports
  drop column tn_image_3;

ALTER TABLE `client_service` 
  ADD PRIMARY KEY (`client_id`, `service_id`);

-- ********************************************************************************************

ALTER TABLE `clients`
  ADD user_id INT;

DELIMITER //
DROP FUNCTION IsEmailUniqueCheck//
CREATE FUNCTION IsEmailUniqueCheck (p_email VARCHAR(255) CHARSET utf8 COLLATE utf8_unicode_ci, p_client_id INT) 
RETURNS int
BEGIN
  DECLARE v_user_id INT;
  DECLARE v_cnt INT;
  
  SELECT DISTINCT user_id INTO v_user_id
  FROM services S, client_service CS
  WHERE S.id = CS.service_id AND
        CS.client_id = p_client_id;

  SELECT COUNT(*) INTO v_cnt 
  FROM clients C1 
  WHERE C1.id <> p_client_id AND
        C1.email = p_email AND
        C1.id in (SELECT CS.client_id
                  FROM client_service CS, services S
                  WHERE CS.service_id = S.id AND
                        S.user_id = v_user_id);
  RETURN v_cnt;
END //

DELIMITER ;
UPDATE `clients` C
SET user_id = (SELECT MAX(user_id)
               FROM services S, client_service CS
               WHERE CS.service_id = S.id AND
                     CS.client_id = C.id);

ALTER TABLE `clients` 
  MODIFY `user_id` INT NOT NULL;

DELIMITER //
DROP FUNCTION IsEmailUniqueCheck //
CREATE FUNCTION IsEmailUniqueCheck (p_email VARCHAR(255) CHARSET utf8 COLLATE utf8_unicode_ci, p_client_id INT) 
RETURNS int
BEGIN
  DECLARE v_user_id INT;
  DECLARE v_cnt INT;
  
  SELECT user_id INTO v_user_id
  FROM clients
  WHERE id = p_client_id;

  SELECT COUNT(*) INTO v_cnt 
  FROM clients C1 
  WHERE C1.id <> p_client_id AND
        C1.email = p_email AND
        C1.user_id = v_user_id;
  RETURN v_cnt;
END //

DELIMITER //
CREATE TRIGGER trg_reports_bi_user_consistency
BEFORE INSERT ON reports
FOR EACH ROW
BEGIN
  DECLARE v_user1 INT;
  DECLARE v_user2 INT;
  DECLARE msg VARCHAR(255);
  
  SELECT user_id INTO v_user1
  FROM services
  WHERE id = NEW.service_id;

  SELECT user_id INTO v_user2
  FROM technicians T, supervisors S
  WHERE T.id = NEW.technician_id AND
        S.id = T.supervisor_id;

  IF v_user1 <> v_user2 THEN
    set msg = concat('ReportUserError: Technician and Service has inconsistent user');
        signal sqlstate '99993' set message_text = msg;
  END IF;
END //

DELIMITER //
CREATE FUNCTION f_gen_seq(p_seq_name VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci, p_user_id INT) RETURNS INT
BEGIN
 UPDATE seq
 SET val = last_insert_id(val+1) 
 WHERE `name` = p_seq_name AND
       `user_id` = p_user_id;
 RETURN last_insert_id();
END
//

delimiter ;
CREATE TABLE `seq` (
  `name` VARCHAR(50) NOT NULL,
  `user_id` INT NOT NULL,
  `val` INT(10) unsigned NOT NULL,
  PRIMARY KEY  (`name`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


ALTER TABLE `clients` 
  ADD `seq_id` INT ;

ALTER TABLE `services` 
  ADD `seq_id` INT ;

ALTER TABLE `reports` 
  ADD `seq_id` INT ;

ALTER TABLE `technicians` 
  ADD `seq_id` INT ;

ALTER TABLE `supervisors` 
  ADD `seq_id` INT ;

INSERT INTO `seq` (`name`, `user_id`, `val`)
  SELECT 'clients', id, 0
  FROM `users`
  UNION ALL
  SELECT 'services', id, 0
  FROM `users`
  UNION ALL
  SELECT 'reports', id, 0
  FROM `users`
  UNION ALL
  SELECT 'supervisors', id, 0
  FROM `users`
  UNION ALL
  SELECT 'technicians', id, 0
  FROM `users`;


UPDATE `clients`
SET `seq_id` = (SELECT f_gen_seq('clients',user_id));

UPDATE `services`
SET `seq_id` = (SELECT DISTINCT f_gen_seq('services',user_id));

UPDATE `reports`
SET `seq_id` = (SELECT DISTINCT f_gen_seq('reports',user_id)
				FROM `services` S
                WHERE S.id = `reports`.service_id);

UPDATE `supervisors`
SET `seq_id` = (SELECT DISTINCT f_gen_seq('supervisors',user_id));

UPDATE `technicians`
SET `seq_id` = (SELECT DISTINCT f_gen_seq('technicians',user_id)
				FROM `supervisors` S
                WHERE S.id = `technicians`.supervisor_id);



ALTER TABLE `clients` 
  MODIFY `seq_id` INT NOT NULL;

ALTER TABLE `services` 
  MODIFY `seq_id` INT NOT NULL ;

ALTER TABLE `reports` 
  MODIFY `seq_id` INT NOT NULL ;

ALTER TABLE `technicians` 
  MODIFY `seq_id` INT NOT NULL ;

ALTER TABLE `supervisors` 
  MODIFY `seq_id` INT NOT NULL ;


DELIMITER //
CREATE TRIGGER trg_users_ai_seq
AFTER INSERT ON users
FOR EACH ROW
BEGIN
  INSERT INTO `seq` (`name`, `user_id`, `val`)
  VALUES ('clients', NEW.id, 0);
  INSERT INTO `seq` (`name`, `user_id`, `val`)
  VALUES ('services', NEW.id, 0);
  INSERT INTO `seq` (`name`, `user_id`, `val`)
  VALUES ('reports', NEW.id, 0);
  INSERT INTO `seq` (`name`, `user_id`, `val`)
  VALUES ('supervisors', NEW.id, 0);
  INSERT INTO `seq` (`name`, `user_id`, `val`)
  VALUES ('technicians', NEW.id, 0);
END //

DELIMITER //
DROP TRIGGER trg_clients_bi_email_unique //
CREATE TRIGGER trg_clients_bi_email_unique_and_seq
BEFORE INSERT ON clients
FOR EACH ROW
BEGIN
  DECLARE res INT;
  DECLARE msg VARCHAR(255);
  SELECT IsEmailUniqueCheck(NEW.email, NEW.id) INTO res;
  IF res > 0 THEN
    set msg = concat('ClientEmailError: Trying to insert duplicite email: ', NEW.email);
        signal sqlstate '99999' set message_text = msg;
  ELSE
    SET NEW.seq_id = (SELECT f_gen_seq('clients',NEW.user_id));
  END IF;
END //

DELIMITER //
CREATE TRIGGER trg_services_bi_seq
BEFORE INSERT ON services
FOR EACH ROW
BEGIN
  SET NEW.seq_id = (SELECT f_gen_seq('services',NEW.user_id));
END //



DELIMITER //
DROP TRIGGER trg_reports_bi_user_consistency //
CREATE TRIGGER trg_reports_bi_user_consistency_and_seq
BEFORE INSERT ON reports
FOR EACH ROW
BEGIN
  DECLARE v_user1 INT;
  DECLARE v_user2 INT;
  DECLARE msg VARCHAR(255);
  
  SELECT user_id INTO v_user1
  FROM services
  WHERE id = NEW.service_id;

  SELECT user_id INTO v_user2
  FROM technicians T, supervisors S
  WHERE T.id = NEW.technician_id AND
        S.id = T.supervisor_id;

  IF v_user1 <> v_user2 THEN
    set msg = concat('ReportUserError: Technician and Service has inconsistent user');
        signal sqlstate '99993' set message_text = msg;
  ELSE
    SET NEW.seq_id = (SELECT f_gen_seq('reports',v_user1));
  END IF;
END //

DELIMITER //
CREATE TRIGGER trg_supervisors_bi_seq
BEFORE INSERT ON supervisors
FOR EACH ROW
BEGIN
  SET NEW.seq_id = (SELECT f_gen_seq('supervisors',NEW.user_id));
END //

DELIMITER //
CREATE TRIGGER trg_technicians_bi_seq
BEFORE INSERT ON technicians
FOR EACH ROW
BEGIN
  DECLARE v_user INT;
  
  SELECT user_id INTO v_user
  FROM supervisors
  WHERE id = NEW.supervisor_id;

  SET NEW.seq_id = (SELECT f_gen_seq('technicians',v_user));

END //
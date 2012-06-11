CREATE TABLE common (id BIGINT AUTO_INCREMENT, series_id BIGINT, customer_id BIGINT, customer_name VARCHAR(100), customer_identification VARCHAR(50), customer_email VARCHAR(100), customer_phone VARCHAR(20), customer_fax VARCHAR(20), invoicing_address LONGTEXT, shipping_address LONGTEXT, contact_person VARCHAR(100), terms LONGTEXT, notes LONGTEXT, base_amount DECIMAL(53, 15), discount_amount DECIMAL(53, 15), net_amount DECIMAL(53, 15), gross_amount DECIMAL(53, 15), paid_amount DECIMAL(53, 15), tax_amount DECIMAL(53, 15), status TINYINT, type VARCHAR(255), draft TINYINT(1) DEFAULT '1', closed TINYINT(1) DEFAULT '0', sent_by_email TINYINT(1) DEFAULT '0', number INT, recurring_invoice_id BIGINT, issue_date DATE, due_date DATE, days_to_due MEDIUMINT, enabled TINYINT(1) DEFAULT '0', max_occurrences INT, must_occurrences INT, period INT, period_type VARCHAR(8), starting_date DATE, finishing_date DATE, last_execution_date DATE, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX cstnm_idx (customer_name), INDEX cstid_idx (customer_identification), INDEX cstml_idx (customer_email), INDEX cntct_idx (contact_person), INDEX common_type_idx (type), INDEX customer_id_idx (customer_id), INDEX series_id_idx (series_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 ENGINE = INNODB;
CREATE TABLE customer (id BIGINT AUTO_INCREMENT, name VARCHAR(100), name_slug VARCHAR(100), identification VARCHAR(50), email VARCHAR(100), contact_person VARCHAR(100), invoicing_address LONGTEXT, shipping_address LONGTEXT, phone VARCHAR(20), fax VARCHAR(20), comments LONGTEXT, UNIQUE INDEX cstm_idx (name), UNIQUE INDEX cstm_slug_idx (name_slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 ENGINE = INNODB;
CREATE TABLE item (id BIGINT AUTO_INCREMENT, quantity DECIMAL(53, 15) DEFAULT 1 NOT NULL, discount DECIMAL(53, 2) DEFAULT 0 NOT NULL, common_id BIGINT, product_id BIGINT, description VARCHAR(255), unitary_cost DECIMAL(53, 15) DEFAULT 0 NOT NULL, INDEX desc_idx (description), INDEX common_id_idx (common_id), INDEX product_id_idx (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 ENGINE = INNODB;
CREATE TABLE item_tax (item_id BIGINT, tax_id BIGINT, PRIMARY KEY(item_id, tax_id)) DEFAULT CHARACTER SET utf8 ENGINE = INNODB;
CREATE TABLE payment (id BIGINT AUTO_INCREMENT, invoice_id BIGINT, date DATE, amount DECIMAL(53, 15), notes LONGTEXT, INDEX invoice_id_idx (invoice_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 ENGINE = INNODB;
CREATE TABLE product (id BIGINT AUTO_INCREMENT, reference VARCHAR(100) NOT NULL, description LONGTEXT, price DECIMAL(53, 15) DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 ENGINE = INNODB;
CREATE TABLE sf_guard_user_profile (id BIGINT AUTO_INCREMENT, sf_guard_user_id INT, first_name VARCHAR(50), last_name VARCHAR(50), email VARCHAR(100) UNIQUE, nb_display_results SMALLINT, language VARCHAR(3), country VARCHAR(2), search_filter VARCHAR(30), series VARCHAR(50), hash VARCHAR(50), INDEX sf_guard_user_id_idx (sf_guard_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 ENGINE = INNODB;
CREATE TABLE property (keey VARCHAR(50), value LONGTEXT, PRIMARY KEY(keey)) DEFAULT CHARACTER SET utf8 ENGINE = INNODB;
CREATE TABLE series (id BIGINT AUTO_INCREMENT, name VARCHAR(255), value VARCHAR(255), first_number INT DEFAULT 1, enabled TINYINT(1) DEFAULT '1', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 ENGINE = INNODB;
CREATE TABLE tag (id BIGINT AUTO_INCREMENT, name VARCHAR(100), is_triple TINYINT(1), triple_namespace VARCHAR(100), triple_key VARCHAR(100), triple_value VARCHAR(100), INDEX name_idx (name), INDEX triple1_idx (triple_namespace), INDEX triple2_idx (triple_key), INDEX triple3_idx (triple_value), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE tagging (id BIGINT AUTO_INCREMENT, tag_id BIGINT NOT NULL, taggable_model VARCHAR(30), taggable_id BIGINT, INDEX tag_idx (tag_id), INDEX taggable_idx (taggable_model, taggable_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE tax (id BIGINT AUTO_INCREMENT, name VARCHAR(50), value DECIMAL(53, 2), active TINYINT(1) DEFAULT '1', is_default TINYINT(1) DEFAULT '0', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 ENGINE = INNODB;
CREATE TABLE template (id BIGINT AUTO_INCREMENT, name VARCHAR(255), template LONGTEXT, models VARCHAR(200), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, slug VARCHAR(255), UNIQUE INDEX template_sluggable_idx (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 ENGINE = INNODB;
CREATE TABLE sf_guard_group (id INT AUTO_INCREMENT, name VARCHAR(255) UNIQUE, description TEXT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_group_permission (group_id INT, permission_id INT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(group_id, permission_id)) ENGINE = INNODB;
CREATE TABLE sf_guard_permission (id INT AUTO_INCREMENT, name VARCHAR(255) UNIQUE, description TEXT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_remember_key (id INT AUTO_INCREMENT, user_id INT, remember_key VARCHAR(32), ip_address VARCHAR(50), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX user_id_idx (user_id), PRIMARY KEY(id, ip_address)) ENGINE = INNODB;
CREATE TABLE sf_guard_user (id INT AUTO_INCREMENT, username VARCHAR(128) NOT NULL UNIQUE, algorithm VARCHAR(128) DEFAULT 'sha1' NOT NULL, salt VARCHAR(128), password VARCHAR(128), is_active TINYINT(1) DEFAULT '1', is_super_admin TINYINT(1) DEFAULT '0', last_login DATETIME, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX is_active_idx_idx (is_active), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_user_group (user_id INT, group_id INT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(user_id, group_id)) ENGINE = INNODB;
CREATE TABLE sf_guard_user_permission (user_id INT, permission_id INT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(user_id, permission_id)) ENGINE = INNODB;
ALTER TABLE common ADD CONSTRAINT common_series_id_series_id FOREIGN KEY (series_id) REFERENCES series(id) ON DELETE SET NULL;
ALTER TABLE common ADD CONSTRAINT common_customer_id_customer_id FOREIGN KEY (customer_id) REFERENCES customer(id) ON DELETE SET NULL;
ALTER TABLE common ADD CONSTRAINT common_recurring_invoice_id_common_id FOREIGN KEY (recurring_invoice_id) REFERENCES common(id) ON DELETE SET NULL;
ALTER TABLE item ADD CONSTRAINT item_product_id_product_id FOREIGN KEY (product_id) REFERENCES product(id) ON DELETE SET NULL;
ALTER TABLE item ADD CONSTRAINT item_common_id_common_id FOREIGN KEY (common_id) REFERENCES common(id) ON DELETE CASCADE;
ALTER TABLE item_tax ADD CONSTRAINT item_tax_item_id_item_id FOREIGN KEY (item_id) REFERENCES item(id) ON DELETE CASCADE;
ALTER TABLE payment ADD CONSTRAINT payment_invoice_id_common_id FOREIGN KEY (invoice_id) REFERENCES common(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_profile ADD CONSTRAINT sf_guard_user_profile_sf_guard_user_id_sf_guard_user_id FOREIGN KEY (sf_guard_user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_group_permission ADD CONSTRAINT sf_guard_group_permission_permission_id_sf_guard_permission_id FOREIGN KEY (permission_id) REFERENCES sf_guard_permission(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_group_permission ADD CONSTRAINT sf_guard_group_permission_group_id_sf_guard_group_id FOREIGN KEY (group_id) REFERENCES sf_guard_group(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_remember_key ADD CONSTRAINT sf_guard_remember_key_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_group ADD CONSTRAINT sf_guard_user_group_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_group ADD CONSTRAINT sf_guard_user_group_group_id_sf_guard_group_id FOREIGN KEY (group_id) REFERENCES sf_guard_group(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_permission ADD CONSTRAINT sf_guard_user_permission_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_permission ADD CONSTRAINT sf_guard_user_permission_permission_id_sf_guard_permission_id FOREIGN KEY (permission_id) REFERENCES sf_guard_permission(id) ON DELETE CASCADE;

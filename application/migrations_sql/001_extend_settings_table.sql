ALTER TABLE settings
  ADD COLUMN setting_group VARCHAR(50) NOT NULL DEFAULT 'general' AFTER setting_label,
  ADD COLUMN setting_type VARCHAR(20) NOT NULL DEFAULT 'text' AFTER setting_group,
  ADD COLUMN is_secret TINYINT(1) NOT NULL DEFAULT 0 AFTER setting_type,
  ADD COLUMN sort_order INT NOT NULL DEFAULT 0 AFTER is_secret;

UPDATE settings SET setting_group='branding', setting_type='text' WHERE setting_label='SITE_NAME';
UPDATE settings SET setting_group='business', setting_type='number' WHERE setting_label='RECORD_PER_PAGE';

ALTER TABLE settings ADD UNIQUE KEY uk_settings_label (setting_label);

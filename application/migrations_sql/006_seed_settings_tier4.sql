INSERT IGNORE INTO settings (setting_title,setting_label,setting_value,setting_group,setting_type,is_secret,sort_order) VALUES
('Default meta title','SEO_META_TITLE','BrickStory - preserving the stories of America''s historic homes','seo','text',0,10),
('Default meta description','SEO_META_DESCRIPTION','','seo','textarea',0,20),
('Default OG image URL','SEO_OG_IMAGE','','seo','image',0,30),
('Google Analytics ID (GA4)','SEO_GOOGLE_ANALYTICS_ID','','seo','text',0,40),
('Google Tag Manager ID','SEO_GOOGLE_TAG_MANAGER_ID','','seo','text',0,50),
('Facebook Pixel ID','SEO_FB_PIXEL_ID','','seo','text',0,60),
('Maintenance mode','SYSTEM_MAINTENANCE_MODE','0','system','boolean',0,10),
('Maintenance message','SYSTEM_MAINTENANCE_MESSAGE','We are performing scheduled maintenance. Please check back shortly.','system','textarea',0,20);

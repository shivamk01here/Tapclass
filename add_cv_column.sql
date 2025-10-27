-- Add CV path column to tutor_profiles table
ALTER TABLE `tutor_profiles` ADD COLUMN `cv_path` VARCHAR(255) NULL AFTER `degree_certificate_path`;

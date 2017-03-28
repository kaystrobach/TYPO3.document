#
# Table structure for table 'tt_content'
#
CREATE TABLE tt_content (
  table_display_sheets text,
  table_display_images INTEGER(1) DEFAULT 1 NOT NULL,
  table_display_colors INTEGER(1) DEFAULT 1 NOT NULL,
);

CREATE TABLE sys_file_metadata (
  table_delimiter VARCHAR(1) DEFAULT ';' NOT NULL,
  table_enclosure VARCHAR(1) DEFAULT '"' NOT NULL,
);
#
# Table structure for table 'tt_content'
#
CREATE TABLE tt_content (
  table_display_sheets text,
);

CREATE TABLE sys_file_metadata (
  table_delimiter VARCHAR(1) DEFAULT ';' NOT NULL,
  table_enclosure VARCHAR(1) DEFAULT '"' NOT NULL,
);
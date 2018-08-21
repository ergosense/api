# generated at 1534773326 by chris
CREATE TABLE IF NOT EXISTS area (
  id              INT UNSIGNED NOT NULL AUTO_INCREMENT,
  parent_area_id  INT UNSIGNED NULL,
  name            VARCHAR(255) NOT NULL,
  active          BOOLEAN      NOT NULL DEFAULT 1,
  PRIMARY KEY(id)
);
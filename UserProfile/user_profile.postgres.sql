-- Postgres version

CREATE TABLE user_profile (
  up_user_id           INTEGER      NOT NULL  DEFAULT 0 PRIMARY KEY,
  up_relationship      INTEGER      NOT NULL  DEFAULT 0,
  up_occupation        TEXT                   DEFAULT '',
  up_character1        TEXT,
  up_character2        TEXT,
  up_character3        TEXT,
  up_character4        TEXT,
  up_character5        TEXT,
  up_seiyuu1           TEXT,
  up_seiyuu2           TEXT,
  up_seiyuu3           TEXT,
  up_seiyuu4           TEXT,
  up_seiyuu5           TEXT,
  up_series1           TEXT,
  up_series2           TEXT,
  up_series3           TEXT,
  up_series4           TEXT,
  up_series5           TEXT,
  up_custom_1          TEXT,
  up_custom_2          TEXT,
  up_custom_3          TEXT,
  up_custom_4          TEXT,
  up_custom_5          TEXT,
  up_last_seen         TIMESTAMPTZ  NOT NULL  DEFAULT now(),
  up_type              INTEGER      NOT NULL  DEFAULT 1
);

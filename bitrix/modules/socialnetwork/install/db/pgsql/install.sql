
CREATE TABLE b_sonet_group_subject (
  ID serial NOT NULL,
  SITE_ID char(2) NOT NULL,
  NAME varchar(255) NOT NULL,
  SORT int NOT NULL DEFAULT '100',
  PRIMARY KEY (ID)
);

CREATE TABLE b_sonet_group_subject_site (
  SUBJECT_ID int NOT NULL,
  SITE_ID char(2) NOT NULL,
  PRIMARY KEY (SUBJECT_ID, SITE_ID)
);

CREATE TABLE b_sonet_group (
  ID serial NOT NULL,
  SITE_ID char(2) NOT NULL,
  NAME varchar(255) NOT NULL,
  DESCRIPTION text NULL,
  DATE_CREATE timestamp NOT NULL,
  DATE_UPDATE timestamp NOT NULL,
  ACTIVE char(1) NOT NULL DEFAULT 'Y',
  VISIBLE char(1) NOT NULL DEFAULT 'Y',
  OPENED char(1) NOT NULL DEFAULT 'N',
  SUBJECT_ID int NOT NULL,
  OWNER_ID int NOT NULL,
  KEYWORDS varchar(255) NULL,
  IMAGE_ID int NULL,
  AVATAR_TYPE varchar(50) NULL,
  NUMBER_OF_MEMBERS int NOT NULL DEFAULT 0,
  NUMBER_OF_MODERATORS int NOT NULL DEFAULT 0,
  INITIATE_PERMS char(1) NOT NULL DEFAULT 'K',
  DATE_ACTIVITY timestamp NOT NULL,
  CLOSED char(1) NOT NULL DEFAULT 'N',
  SPAM_PERMS char(1) NOT NULL DEFAULT 'K',
  PROJECT char(1) NOT NULL DEFAULT 'N',
  PROJECT_DATE_START timestamp NULL,
  PROJECT_DATE_FINISH timestamp NULL,
  SEARCH_INDEX text NULL,
  LANDING char(1) NULL,
  SCRUM_OWNER_ID int NULL,
  SCRUM_MASTER_ID int NULL,
  SCRUM_SPRINT_DURATION int NULL,
  SCRUM_TASK_RESPONSIBLE char(1) NULL,
  PRIMARY KEY (ID)
);
CREATE INDEX ix_b_sonet_group_owner_id ON b_sonet_group (owner_id);

CREATE TABLE b_sonet_group_tag (
  GROUP_ID int NOT NULL,
  NAME varchar(255) NOT NULL,
  PRIMARY KEY (GROUP_ID, NAME)
);
CREATE INDEX ix_b_sonet_group_tag_name ON b_sonet_group_tag (name);

CREATE TABLE b_sonet_group_site (
  GROUP_ID int NOT NULL,
  SITE_ID char(2) NOT NULL,
  PRIMARY KEY (GROUP_ID, SITE_ID)
);

CREATE TABLE b_sonet_user2group (
  ID serial NOT NULL,
  USER_ID int NOT NULL,
  GROUP_ID int NOT NULL,
  ROLE char(1) NOT NULL DEFAULT 'U',
  AUTO_MEMBER char(1) NOT NULL DEFAULT 'N',
  DATE_CREATE timestamp NOT NULL,
  DATE_UPDATE timestamp NOT NULL,
  INITIATED_BY_TYPE char(1) NOT NULL DEFAULT 'U',
  INITIATED_BY_USER_ID int NOT NULL,
  MESSAGE text NULL,
  PRIMARY KEY (ID)
);
CREATE UNIQUE INDEX ux_b_sonet_user2group_user_id_group_id ON b_sonet_user2group (user_id, group_id);
CREATE INDEX ix_b_sonet_user2group_user_id_group_id_role ON b_sonet_user2group (user_id, group_id, role);
CREATE INDEX ix_b_sonet_user2group_group_id_user_id_role ON b_sonet_user2group (group_id, user_id, role);
CREATE INDEX ix_b_sonet_user2group_user_id_role ON b_sonet_user2group (user_id, role);

CREATE TABLE b_sonet_features (
  ID serial NOT NULL,
  ENTITY_TYPE char(1) NOT NULL DEFAULT 'G',
  ENTITY_ID int NOT NULL,
  FEATURE varchar(50) NOT NULL,
  FEATURE_NAME varchar(250) NULL,
  ACTIVE char(1) NOT NULL DEFAULT 'Y',
  DATE_CREATE timestamp NOT NULL,
  DATE_UPDATE timestamp NOT NULL,
  PRIMARY KEY (ID)
);
CREATE UNIQUE INDEX ux_b_sonet_features_entity_type_entity_id_feature ON b_sonet_features (entity_type, entity_id, feature);
CREATE UNIQUE INDEX ux_b_sonet_features_entity_type_feature_active_entity_id ON b_sonet_features (entity_type, feature, active, entity_id);

CREATE TABLE b_sonet_features2perms (
  ID serial NOT NULL,
  FEATURE_ID int NOT NULL,
  OPERATION_ID varchar(50) NOT NULL,
  ROLE char(1) NOT NULL,
  PRIMARY KEY (ID)
);
CREATE UNIQUE INDEX ux_b_sonet_features2perms_feature_id_operation_id ON b_sonet_features2perms (feature_id, operation_id);
CREATE INDEX ix_b_sonet_features2perms_feature_id_role_operation_id ON b_sonet_features2perms (feature_id, role, operation_id);

CREATE TABLE b_sonet_user_relations (
  ID serial NOT NULL,
  FIRST_USER_ID int NOT NULL,
  SECOND_USER_ID int NOT NULL,
  RELATION char(1) NOT NULL DEFAULT 'N',
  DATE_CREATE timestamp NOT NULL,
  DATE_UPDATE timestamp NOT NULL,
  MESSAGE text NULL,
  INITIATED_BY char(1) NOT NULL DEFAULT 'F',
  PRIMARY KEY (ID)
);
CREATE UNIQUE INDEX ux_b_sonet_user_relations_first_user_id_second_user_id ON b_sonet_user_relations (first_user_id, second_user_id);
CREATE INDEX ix_b_sonet_user_relations_first_user_id_second_user_id_relation ON b_sonet_user_relations (first_user_id, second_user_id, relation);
CREATE INDEX ix_b_sonet_user_relations_second_user_id ON b_sonet_user_relations (second_user_id);

CREATE TABLE b_sonet_messages (
  ID serial NOT NULL,
  FROM_USER_ID int NOT NULL,
  TO_USER_ID int NOT NULL,
  TITLE varchar(250) NULL,
  MESSAGE text NULL,
  DATE_CREATE timestamp NOT NULL,
  DATE_VIEW timestamp NULL,
  MESSAGE_TYPE char(1) NOT NULL DEFAULT 'P',
  FROM_DELETED char(1) NOT NULL DEFAULT 'N',
  TO_DELETED char(1) NOT NULL DEFAULT 'N',
  SEND_MAIL char(1) NOT NULL DEFAULT 'N',
  EMAIL_TEMPLATE varchar(250) NULL,
  IS_LOG char(1) NULL,
  PRIMARY KEY (ID)
);
CREATE INDEX ix_b_sonet_messages_from_user_id ON b_sonet_messages (from_user_id);
CREATE INDEX ix_b_sonet_messages_to_user_id ON b_sonet_messages (to_user_id);

CREATE TABLE b_sonet_smile (
  ID smallint NOT NULL,
  SMILE_TYPE char(1) NOT NULL DEFAULT 'S',
  TYPING varchar(100) NULL,
  IMAGE varchar(128) NOT NULL,
  DESCRIPTION varchar(50) NULL,
  CLICKABLE char(1) NOT NULL DEFAULT 'Y',
  SORT int NOT NULL DEFAULT '150',
  IMAGE_WIDTH int NOT NULL DEFAULT '0',
  IMAGE_HEIGHT int NOT NULL DEFAULT '0',
  PRIMARY KEY (ID)
);

CREATE TABLE b_sonet_smile_lang (
  ID serial NOT NULL,
  SMILE_ID int NOT NULL DEFAULT '0',
  LID char(2) NOT NULL,
  NAME varchar(255) NOT NULL,
  PRIMARY KEY (ID)
);
CREATE UNIQUE INDEX ux_b_sonet_smile_lang_smile_id_lid ON b_sonet_smile_lang (smile_id, lid);

CREATE TABLE b_sonet_user_perms (
  ID serial NOT NULL,
  USER_ID int NOT NULL,
  OPERATION_ID varchar(50) NOT NULL,
  RELATION_TYPE char(1) NOT NULL,
  PRIMARY KEY (ID)
);
CREATE UNIQUE INDEX ux_b_sonet_user_perms_user_id_operation_id ON b_sonet_user_perms (user_id, operation_id);

CREATE TABLE b_sonet_user_events (
  ID serial NOT NULL,
  USER_ID int NOT NULL,
  EVENT_ID varchar(50) NOT NULL,
  ACTIVE char(1) NOT NULL DEFAULT 'Y',
  SITE_ID char(2) NOT NULL,
  PRIMARY KEY (ID)
);
CREATE UNIQUE INDEX ux_b_sonet_user_events_user_id_event_id ON b_sonet_user_events (user_id, event_id);

CREATE TABLE b_sonet_log (
  ID serial NOT NULL,
  ENTITY_TYPE varchar(50) NOT NULL DEFAULT 'G',
  ENTITY_ID int NOT NULL,
  EVENT_ID varchar(50) NOT NULL,
  USER_ID int NULL,
  LOG_DATE timestamp NOT NULL,
  SITE_ID char(2) NULL,
  TITLE_TEMPLATE varchar(250) NULL,
  TITLE varchar(250) NOT NULL,
  MESSAGE text NULL,
  TEXT_MESSAGE text NULL,
  URL varchar(500) NULL,
  MODULE_ID varchar(50) NULL,
  CALLBACK_FUNC varchar(250) NULL,
  EXTERNAL_ID varchar(250) NULL,
  PARAMS text NULL,
  TMP_ID int NULL DEFAULT NULL,
  SOURCE_ID int NULL DEFAULT NULL,
  LOG_UPDATE timestamp NOT NULL,
  COMMENTS_COUNT int NULL DEFAULT NULL,
  ENABLE_COMMENTS char(1) NULL DEFAULT 'Y',
  RATING_TYPE_ID varchar(50) NULL DEFAULT NULL,
  RATING_ENTITY_ID int NULL DEFAULT NULL,
  SOURCE_TYPE varchar(50) NULL DEFAULT NULL,
  TRANSFORM char(1) NULL DEFAULT NULL,
  INACTIVE char(1) NULL DEFAULT NULL,
  PRIMARY KEY (ID)
);
CREATE INDEX ix_b_sonet_log_entity_type_entity_id_event_id ON b_sonet_log (entity_type, entity_id, event_id);
CREATE INDEX ix_b_sonet_log_user_id_log_date_event_id ON b_sonet_log (user_id, log_date, event_id);
CREATE INDEX ix_b_sonet_log_source_id ON b_sonet_log (source_id);
CREATE INDEX ix_b_sonet_log_log_update ON b_sonet_log (log_update);
CREATE INDEX ix_b_sonet_log_user_id_entity_type_log_update ON b_sonet_log (user_id, entity_type, log_update);
CREATE INDEX ix_b_sonet_log_module_id ON b_sonet_log (module_id);
CREATE INDEX ix_b_sonet_log_entity_id_event_id ON b_sonet_log (entity_id, event_id);
CREATE INDEX ix_b_sonet_log_rating_entity_id_rating_type_id ON b_sonet_log (rating_entity_id, rating_type_id);
CREATE INDEX ix_b_sonet_log_external_id ON b_sonet_log (external_id);

CREATE TABLE b_sonet_log_site (
  LOG_ID int NOT NULL,
  SITE_ID char(2) NOT NULL,
  PRIMARY KEY (LOG_ID, SITE_ID)
);

CREATE TABLE b_sonet_log_comment (
  ID serial NOT NULL,
  LOG_ID int NOT NULL,
  ENTITY_TYPE varchar(50) NOT NULL DEFAULT 'G',
  ENTITY_ID int NOT NULL,
  EVENT_ID varchar(50) NOT NULL,
  USER_ID int NULL DEFAULT NULL,
  LOG_DATE timestamp NOT NULL,
  MESSAGE text NULL,
  TEXT_MESSAGE text NULL,
  MODULE_ID varchar(50) NULL DEFAULT NULL,
  SOURCE_ID int NULL DEFAULT NULL,
  URL varchar(500) NULL DEFAULT NULL,
  RATING_TYPE_ID varchar(50) NULL DEFAULT NULL,
  RATING_ENTITY_ID int NULL DEFAULT NULL,
  SHARE_DEST text NULL DEFAULT NULL,
  PRIMARY KEY (ID)
);
CREATE INDEX ix_b_sonet_log_comment_entity_type_entity_id_event_id ON b_sonet_log_comment (entity_type, entity_id, event_id);
CREATE INDEX ix_b_sonet_log_comment_user_id_log_date_event_id ON b_sonet_log_comment (user_id, log_date, event_id);
CREATE INDEX ix_b_sonet_log_comment_log_id ON b_sonet_log_comment (log_id);
CREATE INDEX ix_b_sonet_log_comment_source_id ON b_sonet_log_comment (source_id);
CREATE INDEX ix_b_sonet_log_comment_rating_type_id_rating_entity_id ON b_sonet_log_comment (rating_type_id, rating_entity_id);

CREATE TABLE b_sonet_log_events (
  ID serial NOT NULL,
  USER_ID int NOT NULL,
  ENTITY_TYPE varchar(50) NOT NULL DEFAULT 'G',
  ENTITY_ID int NOT NULL,
  ENTITY_CB char(1) NOT NULL DEFAULT 'N',
  ENTITY_MY char(1) NOT NULL DEFAULT 'N',
  EVENT_ID varchar(50) NOT NULL,
  SITE_ID char(2) NULL,
  MAIL_EVENT char(1) NOT NULL DEFAULT 'N',
  TRANSPORT char(1) NOT NULL DEFAULT 'N',
  VISIBLE char(1) NOT NULL DEFAULT 'Y',
  PRIMARY KEY (ID)
);
CREATE INDEX ix_b_sonet_log_events_entity_type_entity_id_event_id ON b_sonet_log_events (entity_type, entity_id, event_id);
CREATE UNIQUE INDEX ux_b_sonet_log_events_user_id_entity_type_entity_id_entity_cb_e ON b_sonet_log_events (user_id, entity_type, entity_id, entity_cb, entity_my, event_id, site_id);
CREATE INDEX ix_b_sonet_log_events_user_id_entity_cb_entity_id ON b_sonet_log_events (user_id, entity_cb, entity_id);
CREATE INDEX ix_b_sonet_log_events_user_id_entity_my_entity_type_entity_id ON b_sonet_log_events (user_id, entity_my, entity_type, entity_id);

CREATE TABLE b_sonet_event_user_view (
  ENTITY_TYPE varchar(50) NOT NULL DEFAULT 'G',
  ENTITY_ID int NOT NULL,
  EVENT_ID varchar(50) NOT NULL,
  USER_ID int NOT NULL DEFAULT 0,
  USER_IM_ID int NOT NULL DEFAULT 0,
  USER_ANONYMOUS char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (ENTITY_TYPE, ENTITY_ID, EVENT_ID, USER_ID, USER_IM_ID)
);
CREATE INDEX ix_b_sonet_event_user_view_user_id_event_id_entity_type_user_an ON b_sonet_event_user_view (user_id, event_id, entity_type, user_anonymous);
CREATE INDEX ix_b_sonet_event_user_view_entity_type_event_id ON b_sonet_event_user_view (entity_type, event_id);

CREATE TABLE b_sonet_log_right (
  ID serial NOT NULL,
  LOG_ID int NOT NULL,
  GROUP_CODE varchar(50) NOT NULL,
  LOG_UPDATE timestamp NULL,
  PRIMARY KEY (ID)
);
CREATE UNIQUE INDEX ux_b_sonet_log_right_log_id_group_code ON b_sonet_log_right (log_id, group_code);
CREATE INDEX ix_b_sonet_log_right_group_code_log_id ON b_sonet_log_right (group_code, log_id);
CREATE INDEX ix_b_sonet_log_right_log_update ON b_sonet_log_right (log_update);

CREATE TABLE b_sonet_log_counter (
  USER_ID int NOT NULL,
  SITE_ID char(2) NOT NULL DEFAULT '**',
  CODE varchar(50) NOT NULL DEFAULT '**',
  CNT int NOT NULL DEFAULT 0,
  LAST_DATE timestamp NULL,
  PAGE_SIZE int NULL DEFAULT null,
  PAGE_LAST_DATE_1 timestamp NULL DEFAULT null,
  PRIMARY KEY (USER_ID, SITE_ID, CODE)
);

CREATE TABLE b_sonet_log_page (
  USER_ID int NOT NULL,
  SITE_ID char(2) NOT NULL DEFAULT '**',
  GROUP_CODE varchar(50) NOT NULL DEFAULT '**',
  PAGE_SIZE int NOT NULL,
  PAGE_NUM int NOT NULL DEFAULT 1,
  PAGE_LAST_DATE timestamp NULL DEFAULT null,
  TRAFFIC_AVG int NULL DEFAULT null,
  TRAFFIC_CNT int NULL DEFAULT null,
  TRAFFIC_LAST_DATE timestamp NULL DEFAULT null,
  PRIMARY KEY (USER_ID, SITE_ID, GROUP_CODE, PAGE_SIZE, PAGE_NUM)
);

CREATE TABLE b_sonet_log_follow (
  USER_ID int NOT NULL,
  CODE varchar(50) NOT NULL DEFAULT '**',
  REF_ID int NOT NULL,
  TYPE char(1) NOT NULL DEFAULT 'Y',
  FOLLOW_DATE timestamp NULL,
  BY_WF char(1) NULL,
  PRIMARY KEY (USER_ID, CODE)
);
CREATE INDEX ix_b_sonet_log_follow_user_id_ref_id ON b_sonet_log_follow (user_id, ref_id);
CREATE INDEX ix_b_sonet_log_follow_user_id_code_type_follow_date ON b_sonet_log_follow (user_id, code, type, follow_date);
CREATE INDEX ix_b_sonet_log_follow_code_type_user_id ON b_sonet_log_follow (code, type, user_id);

CREATE TABLE b_sonet_log_subscribe (
  USER_ID int NOT NULL,
  LOG_ID int NOT NULL,
  TYPE char(3) NOT NULL,
  END_DATE timestamp NULL,
  PRIMARY KEY (USER_ID, LOG_ID, TYPE)
);
CREATE INDEX ix_b_sonet_log_subscribe_log_id ON b_sonet_log_subscribe (log_id);

CREATE TABLE b_sonet_log_smartfilter (
  USER_ID int NOT NULL,
  TYPE char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (USER_ID)
);

CREATE TABLE b_sonet_log_favorites (
  USER_ID int NOT NULL,
  LOG_ID int NOT NULL,
  PRIMARY KEY (USER_ID, LOG_ID)
);
CREATE INDEX ix_b_sonet_log_favorites_log_id ON b_sonet_log_favorites (log_id);

CREATE TABLE b_sonet_log_view (
  USER_ID int NOT NULL,
  EVENT_ID varchar(50) NOT NULL,
  TYPE char(1) NOT NULL DEFAULT 'Y',
  PRIMARY KEY (USER_ID, EVENT_ID)
);

CREATE TABLE b_sonet_subscription (
  ID serial NOT NULL,
  USER_ID int NOT NULL,
  CODE varchar(50) NOT NULL,
  PRIMARY KEY (ID)
);
CREATE UNIQUE INDEX ux_b_sonet_subscription_user_id_code ON b_sonet_subscription (user_id, code);

CREATE TABLE b_sonet_group_view (
  USER_ID int NOT NULL,
  GROUP_ID int NOT NULL,
  DATE_VIEW timestamp NULL DEFAULT NULL,
  PRIMARY KEY (USER_ID, GROUP_ID)
);

CREATE TABLE b_sonet_group_favorites (
  USER_ID int NOT NULL,
  GROUP_ID int NOT NULL,
  DATE_ADD timestamp NULL DEFAULT NULL,
  PRIMARY KEY (USER_ID, GROUP_ID)
);

CREATE TABLE b_sonet_group_pin (
  ID serial NOT NULL,
  USER_ID int NOT NULL,
  GROUP_ID int NOT NULL,
  CONTEXT varchar(100) NULL DEFAULT null,
  PRIMARY KEY (ID)
);
CREATE UNIQUE INDEX ux_b_sonet_group_pin_user_id_group_id_context ON b_sonet_group_pin (user_id, group_id, context);

CREATE TABLE b_sonet_log_index (
  LOG_ID int NOT NULL,
  ITEM_TYPE varchar(10) NOT NULL DEFAULT 'L',
  ITEM_ID int NOT NULL,
  CONTENT text NULL,
  LOG_UPDATE timestamp NULL,
  DATE_CREATE timestamp NULL,
  PRIMARY KEY (ITEM_TYPE, ITEM_ID)
);
CREATE INDEX ix_b_sonet_log_index_log_id ON b_sonet_log_index (log_id);
CREATE INDEX ix_b_sonet_log_index_log_update ON b_sonet_log_index (log_update);
CREATE INDEX ix_b_sonet_log_index_date_create ON b_sonet_log_index (date_create);

CREATE TABLE b_sonet_user_content_view (
  USER_ID int NOT NULL,
  RATING_TYPE_ID varchar(50) NOT NULL,
  RATING_ENTITY_ID int NOT NULL,
  CONTENT_ID varchar(50) NOT NULL,
  DATE_VIEW timestamp NULL DEFAULT NULL,
  PRIMARY KEY (USER_ID, RATING_TYPE_ID, RATING_ENTITY_ID)
);
CREATE INDEX ix_b_sonet_user_content_view_content_id ON b_sonet_user_content_view (content_id);
CREATE INDEX ix_b_sonet_user_content_view_rating_type_id_rating_entity_id ON b_sonet_user_content_view (rating_type_id, rating_entity_id);

CREATE TABLE b_sonet_log_tag (
  LOG_ID int NOT NULL,
  ITEM_TYPE varchar(10) NOT NULL DEFAULT 'L',
  ITEM_ID int NOT NULL,
  NAME varchar(255) NOT NULL,
  PRIMARY KEY (ITEM_TYPE, ITEM_ID, NAME)
);
CREATE INDEX ix_b_sonet_log_tag_log_id ON b_sonet_log_tag (log_id);
CREATE INDEX ix_b_sonet_log_tag_name ON b_sonet_log_tag (name);

CREATE TABLE b_sonet_user_tag (
  USER_ID int NOT NULL,
  NAME varchar(255) NOT NULL,
  PRIMARY KEY (USER_ID, NAME)
);
CREATE INDEX ix_b_sonet_user_tag_name ON b_sonet_user_tag (name);

CREATE TABLE b_sonet_user_welltory (
  ID serial NOT NULL,
  USER_ID int NOT NULL,
  STRESS smallint NOT NULL,
  STRESS_TYPE varchar(100) NULL DEFAULT NULL,
  STRESS_COMMENT varchar(255) NULL DEFAULT NULL,
  DATE_MEASURE timestamp NOT NULL,
  HASH varchar(100) NULL DEFAULT NULL,
  PRIMARY KEY (ID)
);
CREATE INDEX ix_b_sonet_user_welltory_user_id_date_measure ON b_sonet_user_welltory (user_id, date_measure);

CREATE TABLE b_sonet_user_welltory_disclaimer (
  ID serial NOT NULL,
  USER_ID int NOT NULL,
  DATE_SIGNED timestamp NOT NULL,
  PRIMARY KEY (ID)
);
CREATE INDEX ix_b_sonet_user_welltory_disclaimer_user_id ON b_sonet_user_welltory_disclaimer (user_id);

CREATE TABLE b_sonet_log_pinned (
  LOG_ID int NOT NULL,
  USER_ID int NOT NULL,
  PINNED_DATE timestamp NULL DEFAULT null,
  PRIMARY KEY (LOG_ID, USER_ID)
);
CREATE INDEX ix_b_sonet_log_pinned_pinned_date ON b_sonet_log_pinned (pinned_date);

CREATE TABLE b_sonet_space_composition (
  ID int8 GENERATED BY DEFAULT AS IDENTITY NOT NULL,
  USER_ID int8 NOT NULL,
  SPACE_ID int8 NOT NULL,
  SETTINGS text NOT NULL,
  PRIMARY KEY (ID)
);
CREATE UNIQUE INDEX ux_b_sonet_space_composition_user_id_space_id ON b_sonet_space_composition (user_id, space_id);

CREATE TABLE b_sonet_scorer (
    ID int GENERATED BY DEFAULT AS IDENTITY NOT NULL,
    USER_ID int NOT NULL DEFAULT '0',
    SONET_LOG_ID int NOT NULL DEFAULT '0',
    GROUP_ID int NOT NULL DEFAULT '0',
    TYPE varchar(64) NOT NULL DEFAULT '0',
    VALUE int NOT NULL DEFAULT '0',
    PRIMARY KEY (ID)
);
CREATE INDEX ix_b_sonet_scorer_group_id ON b_sonet_scorer (group_id);
CREATE INDEX ix_b_sonet_scorer_user_id_type_sonet_log_id ON b_sonet_scorer (user_id, type, sonet_log_id);

CREATE TABLE b_sonet_scorer_queue (
  ID int GENERATED BY DEFAULT AS IDENTITY NOT NULL,
  USER_ID int NOT NULL,
  TYPE varchar(32) NOT NULL DEFAULT '',
  SONET_LOG_ID int NOT NULL,
  DATETIME timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (ID)
);
CREATE INDEX ix_b_sonet_scorer_queue_user_id_type ON b_sonet_scorer_queue (user_id, type);

CREATE TABLE b_sonet_scorer_event (
  ID int GENERATED BY DEFAULT AS IDENTITY NOT NULL,
  HID varchar(64) NOT NULL,
  TYPE varchar(64) NOT NULL,
  DATA text NOT NULL,
  LOG_DATA text,
  CREATED timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PROCESSED timestamp NOT NULL,
  PRIMARY KEY (ID)
);
CREATE INDEX ix_b_sonet_scorer_event_hid ON b_sonet_scorer_event (hid);
CREATE INDEX ix_b_sonet_scorer_event_processed ON b_sonet_scorer_event (processed);

CREATE TABLE b_sonet_space_user_recent_activity (
	ID int GENERATED BY DEFAULT AS IDENTITY NOT NULL,
	USER_ID int NOT NULL,
	SPACE_ID int NOT NULL,
	TYPE_ID varchar(32) NOT NULL,
	ENTITY_ID int DEFAULT null,
	DATETIME timestamp NOT NULL,
	PRIMARY KEY (ID)
);
CREATE INDEX ix_b_sonet_space_user_recent_activity_datetime ON b_sonet_space_user_recent_activity (datetime);
CREATE INDEX ix_b_sonet_space_user_recent_activity_user_id_space_id ON b_sonet_space_user_recent_activity (user_id, space_id);
CREATE UNIQUE INDEX ux_b_sonet_space_user_recent_activity_space_id_type_id_entity_i ON b_sonet_space_user_recent_activity (space_id, type_id, entity_id, user_id);

CREATE TABLE b_sonet_space_user_latest_activity (
	ID int GENERATED BY DEFAULT AS IDENTITY NOT NULL,
	USER_ID int NOT NULL,
	SPACE_ID int NOT NULL,
	ACTIVITY_ID int NOT NULL,
	PRIMARY KEY (ID)
);
CREATE UNIQUE INDEX ux_b_sonet_space_user_latest_activity_user_id_space_id ON b_sonet_space_user_latest_activity (user_id, space_id);
CREATE TABLE `missions`
(
    `id`          int          NOT NULL AUTO_INCREMENT,
    `title`       varchar(255) NOT NULL,
    `slug`        varchar(255) NOT NULL,
    `description` text(65000)  NOT NULL,
    `nickname`    varchar(45)  NOT NULL,
    `created_at`  datetime     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `closed_at`   datetime              DEFAULT NULL,
    PRIMARY KEY (`id`)

) ENGINE = InnoDB
  AUTO_INCREMENT = 35
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

CREATE TABLE `countries`
(
    `id`            int          NOT NULL AUTO_INCREMENT,
    `name`          varchar(255) NOT NULL,
    `nationalities` varchar(255) NOT NULL,
    `iso3166`       varchar(255) NOT NULL,
    `flag`          blob         NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 246
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

CREATE TABLE `country_mission`
(
    `country_id` int NOT NULL,
    `mission_id` int NOT NULL,
    PRIMARY KEY (country_id, mission_id),
    CONSTRAINT `country_mission_countries_id_fk` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
    CONSTRAINT `country_mission_missions_id_fk` FOREIGN KEY (`mission_id`) REFERENCES `missions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB
  AUTO_INCREMENT = 52
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

CREATE TABLE `users`
(
    `id`         int          NOT NULL AUTO_INCREMENT,
    `lastname`   varchar(255) NOT NULL,
    `firstname`  varchar(255) NOT NULL,
    `email`      varchar(255) NOT NULL,
    `password`   varchar(255) NOT NULL,
    `created_at` datetime     NOT NULL,
    `picture` blob NULL,
    PRIMARY KEY (`id`)

) ENGINE = InnoDB
  AUTO_INCREMENT = 5
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

create table agents
(
    id        int auto_increment
        primary key,
    lastname  varchar(255) not null,
    firstname varchar(255) not null,
    bod       datetime     not null,
    picture   blob         null
)
    collate = utf8mb4_general_ci;

create table country_agent
(
    country_id int not null,
    agent_id int not null,
    constraint country_agent_countries_id_fk
        foreign key (country_id) references countries (id)
            on update cascade on delete cascade,
    constraint country_agent_missions_id_fk
        foreign key (agent_id) references agents (id)
            on update cascade on delete cascade
)
    collate = utf8mb4_general_ci;

create index country_agent_country_id_fk
    on country_agent (country_id);
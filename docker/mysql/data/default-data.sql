CREATE TABLE posters (
    id INT AUTO_INCREMENT NOT NULL,
    md5 VARCHAR(32) NOT NULL,
    url VARCHAR(1024) NOT NULL,
    PRIMARY KEY(id),
    CONSTRAINT unique_md5 UNIQUE (md5)
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;

CREATE TABLE publications (
    externalId VARCHAR(50) NOT NULL,
    title VARCHAR(256) NOT NULL,
    year CHAR(50) NULL,
    type varchar(50) NOT NULL,
    poster_id INT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(externalId),
    CONSTRAINT unique_externalId UNIQUE (externalId),
    CONSTRAINT fk_poster FOREIGN KEY (poster_id) REFERENCES posters(id),
    INDEX `idx_title`(`title`) USING BTREE
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;
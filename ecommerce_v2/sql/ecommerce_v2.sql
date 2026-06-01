CREATE DATABASE IF NOT EXISTS ecommerce_v2;
USE ecommerce_v2;

-- --------------------------------------------------------
-- TABELLA UTENTI
-- --------------------------------------------------------

CREATE TABLE utenti (
    id_utente INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    cognome VARCHAR(50) NOT NULL,
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255),
    tipologia VARCHAR(20) NOT NULL,
    email VARCHAR(100) UNIQUE,
    partita_iva VARCHAR(11) UNIQUE,
    cf CHAR(16) UNIQUE,
    ragione_sociale VARCHAR(100)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- TABELLA PRODOTTI
-- --------------------------------------------------------

CREATE TABLE prodotti (
    id_prodotto INT AUTO_INCREMENT PRIMARY KEY,
    prezzo DECIMAL(10,2) NOT NULL,
    nome VARCHAR(50) NOT NULL,
    descrizione VARCHAR(100) NOT NULL,
    immagine VARCHAR(200),
    n_disponibili INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- TABELLA ORDINI
-- --------------------------------------------------------

CREATE TABLE ordini (
    id_ordine INT AUTO_INCREMENT PRIMARY KEY,
    n_fattura INT NOT NULL,
    data_inizio DATETIME NOT NULL,
    data_spedizione DATETIME,
    data_fine DATETIME,
    id_utente INT,

    CONSTRAINT fk_ordini_utenti
        FOREIGN KEY (id_utente)
        REFERENCES utenti(id_utente)
        ON DELETE SET NULL
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- TABELLA CONTENUTI
-- --------------------------------------------------------

CREATE TABLE contenuti (
    id_contenuto INT AUTO_INCREMENT PRIMARY KEY,
    quantita INT NOT NULL,
    prezzo_tot DECIMAL(10,2) NOT NULL,
    id_ordine INT,
    id_prodotto INT,

    CONSTRAINT fk_contenuti_ordini
        FOREIGN KEY (id_ordine)
        REFERENCES ordini(id_ordine)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT fk_contenuti_prodotti
        FOREIGN KEY (id_prodotto)
        REFERENCES prodotti(id_prodotto)
        ON DELETE SET NULL
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- TABELLA FORNITURE
-- --------------------------------------------------------

CREATE TABLE forniture (
    id_fornitura INT AUTO_INCREMENT PRIMARY KEY,
    id_utente INT,
    id_prodotto INT,

    CONSTRAINT fk_forniture_utenti
        FOREIGN KEY (id_utente)
        REFERENCES utenti(id_utente)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT fk_forniture_prodotti
        FOREIGN KEY (id_prodotto)
        REFERENCES prodotti(id_prodotto)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- DATI DI ESEMPIO
-- --------------------------------------------------------

INSERT INTO utenti (
    nome,
    cognome,
    username,
    password,
    tipologia,
    email
) VALUES (
    'Pippo',
    'Pippa',
    'maikol',
    '123456789',
    'utente',
    'maikol@gmail.com'
);

INSERT INTO prodotti (
    prezzo,
    nome,
    descrizione,
    immagine,
    n_disponibili
) VALUES (
    200.00,
    'Mouse Gaming',
    'Mouse RGB professionale',
    'mouse.jpg',
    3
);

INSERT INTO ordini (
    n_fattura,
    data_inizio,
    data_spedizione,
    data_fine,
    id_utente
) VALUES (
    1001,
    NOW(),
    NULL,
    NULL,
    1
);

INSERT INTO contenuti (
    quantita,
    prezzo_tot,
    id_ordine,
    id_prodotto
) VALUES (
    1,
    200.00,
    1,
    1
);

INSERT INTO forniture (
    id_utente,
    id_prodotto
) VALUES (
    1,
    1
);
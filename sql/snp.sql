CREATE TABLE users (
    email VARCHAR(255) PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE indentor (
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) PRIMARY KEY,
    depart VARCHAR(255) NOT NULL,
    full_info VARCHAR(765) GENERATED ALWAYS AS (CONCAT(name, ' (', depart, ')')) STORED,
    CONSTRAINT full_info_unique UNIQUE (full_info)
);

CREATE TABLE departments (
    department_name VARCHAR(255) PRIMARY KEY
);

CREATE TABLE suppliers (
    supplier_name VARCHAR(255) NOT NULL,
    supplier_phone VARCHAR(20) PRIMARY KEY,
    supplier_address VARCHAR(255) NOT NULL,
    concatenated_data VARCHAR(512) NOT NULL UNIQUE
);

CREATE TABLE assets (
    asset_name VARCHAR(255) PRIMARY KEY
);

CREATE TABLE master_data (
    serial_number INT AUTO_INCREMENT PRIMARY KEY,
    indentor VARCHAR(765) NOT NULL,
    notesheet_purchase_order_no VARCHAR(255) NOT NULL,
    purchase_order_date DATE NOT NULL,
    description JSON NOT NULL,
    nature_of_asset JSON NOT NULL,
    quantity JSON NOT NULL,
    gross_amount JSON NOT NULL,
    bill_no VARCHAR(255) NOT NULL,
    bill_date DATE NOT NULL,
    supplier VARCHAR(512) NOT NULL,
    date_of_receipt DATE NOT NULL,
    date_of_installation DATE NOT NULL,
    department VARCHAR(255) NOT NULL,
    location VARCHAR(255) NOT NULL,
    invoice VARCHAR(765) NOT NULL,
    no_of_item_found_ok JSON,
    shortage JSON,
    excess JSON,
    reported_curr_loc JSON
);

CREATE TABLE client (
    email VARCHAR(255) PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    depart VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL
);

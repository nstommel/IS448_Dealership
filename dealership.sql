-- Open the database with columns and headers turned on like so:
-- sqlite3 -header -column  dealership.db
-- Read the database file using:
-- sqlite3 dealership.db ".read dealership.sql"

-- Turn on foreign keys
PRAGMA foreign_keys = ON;

DROP TRIGGER validate_sale_role_insert;
DROP TRIGGER validate_sale_role_update;
DROP TRIGGER validate_service_role_insert;
DROP TRIGGER validate_service_role_update;
DROP TABLE service;
DROP TABLE sale;
DROP TABLE customer;
DROP TABLE vehicle;
DROP TABLE employee;
DROP TABLE dealership;

CREATE TABLE dealership (
    dealership_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    dealership_name TEXT NOT NULL,
    dealership_city TEXT,
    dealership_state TEXT,
    dealership_phone TEXT
);

CREATE TABLE employee (
    employee_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    dealership_id INTEGER NOT NULL,
    employee_fname TEXT NOT NULL,
    employee_lname TEXT NOT NULL,
    employee_email TEXT NOT NULL UNIQUE,
    employee_phone TEXT,
    employee_role TEXT NOT NULL,
    employee_password TEXT,
    FOREIGN KEY(dealership_id) REFERENCES dealership(dealership_id),
    CHECK(employee_role IN ("Salesperson", "Manager", "Mechanic"))
);

CREATE TABLE vehicle (
    vin INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    model_name TEXT,
    model_year INTEGER,
    brand_name TEXT,
    color TEXT,
    msrp REAL
);

CREATE TABLE customer (
    customer_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    customer_fname TEXT NOT NULL,
    customer_lname TEXT NOT NULL,
    customer_email TEXT NOT NULL UNIQUE,
    customer_phone TEXT
);

CREATE TABLE sale (
    sale_num INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    vin INTEGER NOT NULL UNIQUE,
    employee_id INTEGER NOT NULL,
    customer_id INTEGER NOT NULL,
    dealership_id INTEGER NOT NULL,
    sale_date TEXT,
    sale_cost REAL,
    FOREIGN KEY(vin) REFERENCES vehicle(vin),
    FOREIGN KEY(employee_id) REFERENCES employee(employee_id),
    FOREIGN KEY(customer_id) REFERENCES customer(customer_id),
    FOREIGN KEY(dealership_id) REFERENCES dealership(dealership_id)
);

-- This trigger prevents sales from being associated with employees without the
-- Salesperson role.
CREATE TRIGGER validate_sale_role_insert AFTER INSERT ON sale
WHEN (SELECT employee_role FROM employee, sale WHERE employee.employee_id = sale.employee_id AND sale.sale_num = NEW.sale_num) <> "Salesperson"
BEGIN
    SELECT RAISE(ABORT, "Employee on sale is not a saleperson.");
END;

CREATE TRIGGER validate_sale_role_update AFTER UPDATE ON sale
WHEN (SELECT employee_role FROM employee, sale WHERE employee.employee_id = sale.employee_id AND sale.sale_num = OLD.sale_num) <> "Salesperson"
BEGIN
    SELECT RAISE(ABORT, "Employee on sale is not a saleperson.");
END;

CREATE TABLE service (
    service_num INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    vin INTEGER NOT NULL,
    employee_id INTEGER NOT NULL,
    customer_id INTEGER NOT NULL,
    dealership_id INTEGER NOT NULL,
    service_date TEXT,
    service_cost REAL,
    FOREIGN KEY(vin) REFERENCES vehicle(vin),
    FOREIGN KEY(employee_id) REFERENCES employee(employee_id),
    FOREIGN KEY(customer_id) REFERENCES customer(customer_id),
    FOREIGN KEY(dealership_id) REFERENCES dealership(dealership_id)
);

-- This trigger prevents services from being associated with employees without
--the Mechanic role.
CREATE TRIGGER validate_service_role_insert AFTER INSERT ON service
WHEN (SELECT employee_role FROM employee, service WHERE employee.employee_id = service.employee_id AND service_num = NEW.service_num) <> "Mechanic"
BEGIN
    SELECT RAISE(ABORT, "Employee on service is not a mechanic.");
END;

CREATE TRIGGER validate_service_role_update AFTER UPDATE ON service
WHEN (SELECT employee_role FROM employee, service WHERE employee.employee_id = service.employee_id AND service_num = OLD.service_num) <> "Mechanic"
BEGIN
    SELECT RAISE(ABORT, "Employee on service is not a mechanic.");
END;

INSERT INTO dealership (dealership_name, dealership_city, dealership_state, dealership_phone)
    VALUES ("Quality Cars of Maryland", "Baltimore", "MD", "855-902-1024");
INSERT INTO dealership (dealership_name, dealership_city, dealership_state, dealership_phone)
    VALUES ("Quality Cars of Delaware", "Dover", "DE", "522-872-1832");
INSERT INTO dealership (dealership_name, dealership_city, dealership_state, dealership_phone)
    VALUES ("Quality Cars of Pennsylvania", "Pittsburgh", "PA", "772-804-7721");
INSERT INTO dealership (dealership_name, dealership_city, dealership_state, dealership_phone)
    VALUES ("Quality Cars of Virginia", "Richmond", "VA", "310-878-9021");

INSERT INTO employee (dealership_id, employee_fname, employee_lname, employee_email, employee_phone, employee_role, employee_password)
    VALUES (1, "Bob", "Thompson", "bt@qc.com", "443-492-7034", "Manager", "1234");
INSERT INTO employee (dealership_id, employee_fname, employee_lname, employee_email, employee_phone, employee_role, employee_password)
    VALUES (2, "Rick", "Jameson", "rjameson@qc.com", "345-123-9827", "Mechanic", "4321");
INSERT INTO employee (dealership_id, employee_fname, employee_lname, employee_email, employee_phone, employee_role, employee_password)
    VALUES (1, "Mary", "Jane", "mjane@qc.com", "301-902-3485", "Salesperson", "abcd");
INSERT INTO employee (dealership_id, employee_fname, employee_lname, employee_email, employee_phone, employee_role, employee_password)
    VALUES (2, "Jean", "Brown", "jbrown@qc.com", "410-823-4053", "Mechanic", "4321");
INSERT INTO employee (dealership_id, employee_fname, employee_lname, employee_email, employee_phone, employee_role, employee_password)
    VALUES (3, "Will", "Johnson", "wjohnson@qc.com", "455-421-9034", "Manager", "9876");
INSERT INTO employee (dealership_id, employee_fname, employee_lname, employee_email, employee_phone, employee_role, employee_password)
    VALUES (3, "Ron", "Hagerty", "rhagerty@qc.com", "231-903-8023", "Salesperson", "abcd");
INSERT INTO employee (dealership_id, employee_fname, employee_lname, employee_email, employee_phone, employee_role, employee_password)
    VALUES (3, "Amy", "Waterhouse", "awat@qc.com", "432-894-0912", "Mechanic", "4321");
INSERT INTO employee (dealership_id, employee_fname, employee_lname, employee_email, employee_phone, employee_role, employee_password)
    VALUES (2, "Nick", "Hightower", "nht@qc.com", "455-342-9087", "Salesperson", "abcd");
INSERT INTO employee (dealership_id, employee_fname, employee_lname, employee_email, employee_phone, employee_role, employee_password)
    VALUES (2, "Gabe", "Newman", "gnewman@qc.com", "301-423-9087", "Manager", "abcd");
INSERT INTO employee (dealership_id, employee_fname, employee_lname, employee_email, employee_phone, employee_role, employee_password)
    VALUES (1, "Jordan", "Brown", "jordanbrown@qc.com", "443-907-2134", "Salesperson", "1234");

INSERT INTO vehicle (model_name, model_year, brand_name, color, msrp)
    VALUES ("Accord", 2022, "Honda", "White", 19000);
INSERT INTO vehicle (model_name, model_year, brand_name, color, msrp)
    VALUES ("Civic", 2021, "Honda", "Black", 25000);
INSERT INTO vehicle (model_name, model_year, brand_name, color, msrp)
    VALUES ("Camry", 2022, "Toyota", "Blue", 28000);
INSERT INTO vehicle (model_name, model_year, brand_name, color, msrp)
    VALUES ("Highlander", 2021, "Toyota", "Green", 35000);
INSERT INTO vehicle (model_name, model_year, brand_name, color, msrp)
    VALUES ("Highlander", 2022, "Toyota", "Red", 36000);
INSERT INTO vehicle (model_name, model_year, brand_name, color, msrp)
    VALUES ("Tundra", 2020, "Toyota", "Red", 25000);

INSERT INTO customer (customer_fname, customer_lname, customer_email, customer_phone)
    VALUES ("Ron", "Baker", "rbaker@gmail.com", "902-113-2981");
INSERT INTO customer (customer_fname, customer_lname, customer_email, customer_phone)
    VALUES ("Martha", "Davis", "mdavis@outlook.com", "332-907-6281");
INSERT INTO customer (customer_fname, customer_lname, customer_email, customer_phone)
    VALUES ("Angela", "Davis", "adavis@gmail.com", "432-901-7032");
INSERT INTO customer (customer_fname, customer_lname, customer_email, customer_phone)
    VALUES ("Carlos", "Garcia", "cgarcia@yahoo.com", "802-332-8124");
INSERT INTO customer (customer_fname, customer_lname, customer_email, customer_phone)
    VALUES("John", "Anderson", "janderson@outlook.com", "422-470-1238");

-- For sales, the location of the sale is determined by the dealership id

INSERT INTO sale (vin, employee_id, customer_id, dealership_id, sale_date, sale_cost)
    VALUES (1, 3, 1, 2, "2022-01-20", 21000.75);
INSERT INTO sale (vin, employee_id, customer_id, dealership_id, sale_date, sale_cost)
    VALUES (2, 8, 1, 3, "2022-03-20", 27000.25);
INSERT INTO sale (vin, employee_id, customer_id, dealership_id, sale_date, sale_cost)
    VALUES (3, 3, 2, 1, "2022-04-20", 30000.50);
INSERT INTO sale (vin, employee_id, customer_id, dealership_id, sale_date, sale_cost)
    VALUES (4, 6, 4, 3, "2022-03-25", 27000.75);
INSERT INTO sale (vin, employee_id, customer_id, dealership_id, sale_date, sale_cost)
    VALUES (5, 8, 2, 3, "2022-03-20", 28000.25);

-- Test insert trigger on sale table with employee that is not Salesperson
-- INSERT INTO sale (vin, employee_id, customer_id, dealership_id, sale_date, sale_cost)
--    VALUES (6, 1, 2, 3, "2022-03-20", 28000.25);

-- Test update trigger on sale table with employee that is not Salesperson
-- UPDATE sale SET employee_id = 1 WHERE sale_num = 3;

-- A trigger might be used to enforce that employees who sell cars must be located 
-- at the dealership of origin associated with the vehicle, but this is not necessarily 
-- useful because employees could temporarily relocate to other dealerships.

-- For services, the location of the service is determined by the dealership id
-- because a customer could take the car to different service locations after purchase.

INSERT INTO service (vin, employee_id, customer_id, dealership_id, service_date, service_cost)
    VALUES (1, 4, 1, 1, "2022-05-03", 200.00);
INSERT INTO service (vin, employee_id, customer_id, dealership_id, service_date, service_cost)
    VALUES (2, 2, 1, 2, "2022-05-03", 500.00);
INSERT INTO service (vin, employee_id, customer_id, dealership_id, service_date, service_cost)
    VALUES (3, 7, 2, 2, "2022-06-21", 300.00);
INSERT INTO service (vin, employee_id, customer_id, dealership_id, service_date, service_cost)
    VALUES (4, 4, 4, 1, "2022-07-30", 600.00);
INSERT INTO service (vin, employee_id, customer_id, dealership_id, service_date, service_cost)
    VALUES (4, 2, 4, 3, "2022-12-21", 250.00);

-- Test insert trigger on service table with employee that is not a Mechanic
-- INSERT INTO service (vin, employee_id, customer_id, dealership_id, service_date, service_cost)
--     VALUES (4, 1, 4, 3, "12/21/22", 250.00);

-- Test update trigger on service table with employee that is not a Mechanic
-- UPDATE service SET employee_id = 1 WHERE service_num = 3;

-- !!!Perhaps create a vehicle_stock table to include records of dealership vehicle orders and to which dealership they are being offered
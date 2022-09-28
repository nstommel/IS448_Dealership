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
    dealership_id INTEGER NOT NULL,
    model_name TEXT,
    model_year INTEGER,
    brand_name TEXT,
    color TEXT,
    msrp REAL,
    FOREIGN KEY(dealership_id) REFERENCES dealership(dealership_id)
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
    sale_date TEXT,
    sale_amount REAL,
    FOREIGN KEY(vin) REFERENCES vehicle(vin),
    FOREIGN KEY(employee_id) REFERENCES employee(employee_id),
    FOREIGN KEY(customer_id) REFERENCES customer(customer_id)
);

-- This trigger prevents sales from being associated with employees without the
-- Salesperson role.
CREATE TRIGGER validate_sale_role_insert AFTER INSERT ON sale
WHEN (SELECT employee_role FROM employee NATURAL JOIN sale WHERE sale.sale_num = NEW.sale_num) <> "Salesperson"
BEGIN
    SELECT RAISE(ABORT, "Employee on sale is not a saleperson.");
END;

CREATE TRIGGER validate_sale_role_update AFTER UPDATE ON sale
WHEN (SELECT employee_role FROM employee NATURAL JOIN sale WHERE sale.sale_num = OLD.sale_num) <> "Salesperson"
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
    VALUES ("Quality Cars of Maryland", "Baltimore", "Maryland", "855-902-1024");
INSERT INTO dealership (dealership_name, dealership_city, dealership_state, dealership_phone)
    VALUES ("Quality Cars of Delaware", "Dover", "Delware", "522-872-1832");
INSERT INTO dealership (dealership_name, dealership_city, dealership_state, dealership_phone)
    VALUES ("Quality Cars of Pennsylvania", "Pittsburgh", "Pennsylvania", "772-804-7721");

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

INSERT INTO vehicle (dealership_id, model_name, model_year, brand_name, color, msrp)
    VALUES (2, "Accord", 2022, "Honda", "white", 19000);
INSERT INTO vehicle (dealership_id, model_name, model_year, brand_name, color, msrp)
    VALUES (3, "Civic", 2021, "Honda", "black", 25000);
INSERT INTO vehicle (dealership_id, model_name, model_year, brand_name, color, msrp)
    VALUES (1, "Camry", 2022, "Toyota", "blue", 28000);
INSERT INTO vehicle (dealership_id, model_name, model_year, brand_name, color, msrp)
    VALUES (3, "Highlander", 2021, "Toyota", "green", 35000);
INSERT INTO vehicle (dealership_id, model_name, model_year, brand_name, color, msrp)
    VALUES (3, "Highlander", 2022, "Toyota", "red", 36000);

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

INSERT INTO sale (vin, employee_id, customer_id, sale_date, sale_amount)
    VALUES (1, 3, 1, "01/20/22", 21000.75);
INSERT INTO sale (vin, employee_id, customer_id, sale_date, sale_amount)
    VALUES (2, 8, 1, "03/20/22", 27000.25);
INSERT INTO sale (vin, employee_id, customer_id, sale_date, sale_amount)
    VALUES (3, 3, 2, "04/20/22", 30000.50);
INSERT INTO sale (vin, employee_id, customer_id, sale_date, sale_amount)
    VALUES (4, 6, 4, "03/25/22", 27000.75);
INSERT INTO sale (vin, employee_id, customer_id, sale_date, sale_amount)
   VALUES (5, 8, 2, "03/20/22", 28000.25);

-- Test insert trigger on sale table with employee that is not Salesperson
-- INSERT INTO sale (vin, employee_id, customer_id, sale_date, sale_amount)
--    VALUES (6, 1, 2, "03/20/22", 28000.25);

-- Test update trigger on sale table with employee that is not Salesperson
-- UPDATE sale SET employee_id = 1 WHERE sale_num = 3;

-- To see the dealership location where cars were offered vs employee dealership location 
-- affiliatiated with sales, use this query. A trigger might be used to enforce that employees 
-- who sell cars must be located at the dealership of origin associated with the vehicle, but 
-- this is not necessarily useful because employees could temporarily relocate to other
-- dealerships. The dealership_id of the vehicle should be changed by 
-- users in the database should the car be transferred to a different dealership before sale.
-- Thus, dealership_id in the vehicle table determines the sale location and including
-- a dealership_id in the sale table is unneccessary. Including it in the vehicle
-- table brings the benefit of knowing the dealership location where an unsold car is offered.
-- select sale_num, sale.vin, employee.dealership_id as employee_location, 
-- vehicle.dealership_id as sale_location, dealership_name as sale_dealership_name
-- from sale, employee, vehicle, dealership 
-- where sale.employee_id = employee.employee_id 
-- and sale.vin = vehicle.vin
-- and dealership.dealership_id = vehicle.dealership_id;

-- For services, the location of the service is determined in the service record
-- because a customer could take the car to different service locations after purchase.

INSERT INTO service (vin, employee_id, customer_id, dealership_id, service_date, service_cost)
    VALUES (1, 4, 1, 1, "05/03/22", 200.00);
INSERT INTO service (vin, employee_id, customer_id, dealership_id, service_date, service_cost)
    VALUES (2, 2, 1, 2, "05/03/22", 500.00);
INSERT INTO service (vin, employee_id, customer_id, dealership_id, service_date, service_cost)
    VALUES (3, 7, 2, 2, "06/21/22", 300.00);
INSERT INTO service (vin, employee_id, customer_id, dealership_id, service_date, service_cost)
    VALUES (4, 4, 4, 1, "07/30/22", 600.00);
INSERT INTO service (vin, employee_id, customer_id, dealership_id, service_date, service_cost)
    VALUES (4, 2, 4, 3, "12/21/22", 250.00);

-- Test insert trigger on service table with employee that is not a Mechanic
-- INSERT INTO service (vin, employee_id, customer_id, dealership_id, service_date, service_cost)
--     VALUES (4, 1, 4, 3, "12/21/22", 250.00);

-- Test update trigger on service table with employee that is not a Mechanic
-- UPDATE service SET employee_id = 1 WHERE service_num = 3;
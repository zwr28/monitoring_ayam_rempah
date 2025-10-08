-- create_tables.sql
CREATE TABLE IF NOT EXISTS users (
  id SERIAL PRIMARY KEY,
  username VARCHAR(100) UNIQUE NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP WITH TIME ZONE DEFAULT now()
);

CREATE TABLE IF NOT EXISTS orders (
  id SERIAL PRIMARY KEY,
  customer_name VARCHAR(200) DEFAULT 'Pembeli',
  note TEXT,
  delivery_time TIMESTAMP WITH TIME ZONE,
  start_time TIMESTAMP WITH TIME ZONE,
  duration_memasak INTEGER DEFAULT 15,
  duration_packing INTEGER DEFAULT 5,
  duration_mengantar INTEGER DEFAULT 20,
  status_override VARCHAR(50),
  created_at TIMESTAMP WITH TIME ZONE DEFAULT now()
);

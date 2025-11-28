-- SHOP Database Schema
-- PostgreSQL-compatible DDL implementing the project requirements.

CREATE TABLE service_types (
    id SERIAL PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    slug VARCHAR(150) UNIQUE NOT NULL,
    position SMALLINT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE
);

CREATE TABLE categories (
    id SERIAL PRIMARY KEY,
    service_type_id INT NOT NULL REFERENCES service_types(id) ON DELETE CASCADE,
    name VARCHAR(150) NOT NULL,
    slug VARCHAR(150) UNIQUE NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    position SMALLINT DEFAULT 0
);

CREATE TABLE products (
    id SERIAL PRIMARY KEY,
    category_id INT NOT NULL REFERENCES categories(id) ON DELETE CASCADE,
    name VARCHAR(200) NOT NULL,
    slug VARCHAR(200) UNIQUE NOT NULL,
    short_description TEXT,
    description TEXT,
    status_text VARCHAR(100),
    is_visible BOOLEAN DEFAULT TRUE,
    is_featured BOOLEAN DEFAULT FALSE,
    is_pinned BOOLEAN DEFAULT FALSE,
    min_price NUMERIC(12, 2),
    max_price NUMERIC(12, 2),
    review_enabled BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT NOW(),
    updated_at TIMESTAMP DEFAULT NOW()
);

CREATE TABLE product_option_groups (
    id SERIAL PRIMARY KEY,
    product_id INT NOT NULL REFERENCES products(id) ON DELETE CASCADE,
    name VARCHAR(100) NOT NULL,
    display_type VARCHAR(10) DEFAULT 'buttons', -- buttons | dropdown (>5 items)
    position SMALLINT DEFAULT 0,
    required BOOLEAN DEFAULT TRUE
);

CREATE TABLE product_option_values (
    id SERIAL PRIMARY KEY,
    group_id INT NOT NULL REFERENCES product_option_groups(id) ON DELETE CASCADE,
    value VARCHAR(100) NOT NULL,
    position SMALLINT DEFAULT 0
);

CREATE TABLE product_variants (
    id SERIAL PRIMARY KEY,
    product_id INT NOT NULL REFERENCES products(id) ON DELETE CASCADE,
    sku VARCHAR(100) UNIQUE NOT NULL,
    price NUMERIC(12, 2) NOT NULL,
    status_text VARCHAR(100),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT NOW()
);

CREATE TABLE variant_option_values (
    variant_id INT NOT NULL REFERENCES product_variants(id) ON DELETE CASCADE,
    option_value_id INT NOT NULL REFERENCES product_option_values(id) ON DELETE CASCADE,
    PRIMARY KEY (variant_id, option_value_id)
);

CREATE TABLE product_media (
    id SERIAL PRIMARY KEY,
    product_id INT NOT NULL REFERENCES products(id) ON DELETE CASCADE,
    image_url TEXT NOT NULL,
    alt_text VARCHAR(150),
    position SMALLINT DEFAULT 0
);

CREATE TABLE reviews (
    id SERIAL PRIMARY KEY,
    product_id INT NOT NULL REFERENCES products(id) ON DELETE CASCADE,
    nickname VARCHAR(80),
    rating SMALLINT CHECK (rating BETWEEN 1 AND 5),
    content TEXT NOT NULL,
    ip_address INET NOT NULL,
    created_at TIMESTAMP DEFAULT NOW(),
    is_hidden BOOLEAN DEFAULT FALSE
);

CREATE TABLE blog_posts (
    id SERIAL PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(200) UNIQUE NOT NULL,
    cover_image TEXT,
    excerpt TEXT,
    content TEXT,
    is_visible BOOLEAN DEFAULT TRUE,
    published_at TIMESTAMP DEFAULT NOW(),
    created_at TIMESTAMP DEFAULT NOW(),
    updated_at TIMESTAMP DEFAULT NOW()
);

CREATE TABLE popup_settings (
    id SERIAL PRIMARY KEY,
    is_enabled BOOLEAN DEFAULT FALSE,
    image_url TEXT,
    title VARCHAR(150),
    body TEXT,
    action_label VARCHAR(80),
    action_url TEXT,
    updated_at TIMESTAMP DEFAULT NOW()
);

CREATE TABLE banners (
    id SERIAL PRIMARY KEY,
    title VARCHAR(150),
    subtitle TEXT,
    image_url TEXT,
    button_label VARCHAR(80),
    button_url TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    position SMALLINT DEFAULT 0
);

CREATE TABLE footer_settings (
    id SERIAL PRIMARY KEY,
    logo_url TEXT,
    description TEXT,
    qr_code_url TEXT,
    mini_banner_url TEXT,
    copyright_text VARCHAR(255),
    policies JSONB,
    quick_links JSONB,
    updated_at TIMESTAMP DEFAULT NOW()
);

CREATE TABLE contact_links (
    id SERIAL PRIMARY KEY,
    type VARCHAR(20) NOT NULL, -- messenger | zalo | telegram | whatsapp
    url TEXT NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    position SMALLINT DEFAULT 0
);

CREATE TABLE site_settings (
    id SERIAL PRIMARY KEY,
    dark_mode_default BOOLEAN DEFAULT TRUE,
    hero_search_placeholder VARCHAR(150),
    admin_base_path VARCHAR(120) NOT NULL,
    updated_at TIMESTAMP DEFAULT NOW()
);

CREATE TABLE carts (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    created_at TIMESTAMP DEFAULT NOW(),
    updated_at TIMESTAMP DEFAULT NOW()
);

CREATE TABLE cart_items (
    id SERIAL PRIMARY KEY,
    cart_id UUID NOT NULL REFERENCES carts(id) ON DELETE CASCADE,
    product_id INT NOT NULL REFERENCES products(id),
    variant_id INT REFERENCES product_variants(id),
    quantity INT DEFAULT 1,
    UNIQUE (cart_id, variant_id)
);

CREATE TABLE admin_users (
    id SERIAL PRIMARY KEY,
    email VARCHAR(180) UNIQUE NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT NOW()
);

CREATE TABLE admin_sessions (
    id SERIAL PRIMARY KEY,
    admin_id INT NOT NULL REFERENCES admin_users(id) ON DELETE CASCADE,
    otp_secret VARCHAR(100) NOT NULL,
    otp_expires_at TIMESTAMP NOT NULL,
    issued_at TIMESTAMP DEFAULT NOW()
);


CREATE TABLE YQI_button_clicks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    button_name VARCHAR(100),
    page_url TEXT,
    user_ip VARCHAR(50),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
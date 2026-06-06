erDiagram
    USER ||--o{ ORDER : "hasMany (1-n)"
    USER ||--o{ BALANCE_TRANSACTION : "hasMany (1-n)"
    ORDER ||--|{ ORDER_ITEM : "hasMany (1-n)"
    ORDER_ITEM }|--|| PRODUCT : "belongsTo (n-1)"
    
    USER {
        int id PK
        string name
        string email
        decimal balance
        boolean is_active
    }
    PRODUCT {
        int id PK
        string title
        int stock
        decimal price
    }
    ORDER {
        int id PK
        int user_id FK
        decimal total_price
        string status
    }
    ORDER_ITEM {
        int id PK
        int order_id FK
        int product_id FK
        int quantity
        decimal price
    }
    BALANCE_TRANSACTION {
        int id PK
        int user_id FK
        decimal amount
        string type
    }

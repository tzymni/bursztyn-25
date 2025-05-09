db = db.getSiblingDB(process.env.DB_DATABASE || "bursztyn");

db.createUser({
    user: process.env.DB_USERNAME || "admin",
    pwd: process.env.DB_PASSWORD || "admin",
    roles: [
        {
            role: "readWrite",
            db: process.env.DB_DATABASE || "bursztyn"
        }
    ]
});
db.sessions.dropIndex("id_1")

print("MongoDB user created successfully!");

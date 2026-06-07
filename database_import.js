const mysql = require('mysql2/promise');
const fs = require('fs');
const path = require('path');

async function importSql() {
    const host = process.argv[2];
    const user = process.argv[3];
    const password = process.argv[4];
    const database = process.argv[5];
    const port = process.argv[6] || 3306;

    if (!host || !user || !database) {
        console.error('Kullanim: node database_import.js <host> <user> <password> <database> [port]');
        process.exit(1);
    }

    console.log('Veritabanina baglaniliyor: ' + host + ':' + port + '/' + database + '...');
    try {
        const connection = await mysql.createConnection({
            host,
            user,
            password,
            database,
            port: parseInt(port),
            multipleStatements: true
        });

        console.log('backup.sql dosyasi okunuyor...');
        const sqlPath = path.join(__dirname, 'backup.sql');
        if (!fs.existsSync(sqlPath)) {
            throw new Error('backup.sql dosyasi bulunamadi! Proje ana dizininde oldugundan emin olun.');
        }
        const sql = fs.readFileSync(sqlPath, 'utf8');

        console.log('SQL komutlari calistirilip veriler yukleniyor...');
        await connection.query(sql);
        console.log('Veritabani basariyla ice aktarildi!');
        await connection.end();
    } catch (err) {
        console.error('Baglanti veya ice aktarma hatasi:', err.message);
        process.exit(1);
    }
}

importSql().catch(err => {
    console.error('Kritik Hata:', err);
    process.exit(1);
});
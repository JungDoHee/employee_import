# 📂 Employee Info File Upload System

LaravelとVue.jsを利用したCSVファイルアップロードシステムです。

---

## 📑 機能

- CSVファイルをドラッグ＆ドロップおよび、クリックでアップロード
- ファイル拡張子検証（.csv）
- Laravelにファイル保存
- ファイルを保存する前に各ファイル削除機能
- DBにファイルパス保存

---

## 🛠️ 技術

- Laravel１２
- Vue 3 (Vite)
- Axios
- Tailwind CSS

---

📂ファイルの構造
├── app/  
│   └── Http/Controllers/Employee/FileUploadController.php  
├── resources/  
│   └── js/  
│       └── components/FileUpload.vue  
│   └── views/  
│       └── employee  
│           └── fileUploadIndex.blade.php  
├── routes/  
│   └── web.php  
├── database/  
│   └── migrations/  
│       └── 2024_XX_XX_create_employee_info_file_table.php  
└── storage/  
    └── app/uploads/  

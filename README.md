# Unicode Sanitizer

A lightweight PHP tool to detect and remove invisible Unicode characters such as:

- UTF-8 BOM (`U+FEFF`)
- Zero Width Space (`U+200B`)
- Zero Width Non-Joiner (`U+200C`)
- Zero Width Joiner (`U+200D`)

These characters often cause subtle bugs in PHP, JavaScript, and HTML projects.

---

## 🚀 Features

- Detect hidden Unicode characters across your project
- Automatically clean infected files
- Safe for batch processing
- Skips vendor/minified files
- Zero dependencies

---

## 📦 Files

- `finder.php` → scans and reports infected files
- `resolver.php` → cleans files automatically

---

## 🧪 Usage

### 1. Scan project

```bash
php finder.php
```

Output example:

```
INVALID: ./Action/UserCreate.php
INVALID: ./Route/Login.php

Scan complete.
Checked: 120 files
Infected: 8 files
```

### 2. Fix all files

```bash
php resolver.php
```

Output example:

```
FIXED: ./Action/UserCreate.php
FIXED: ./Route/Login.php

Done.
Checked: 120 files
Fixed: 8 files
```

### ⚠️ Why This Matters

Invisible Unicode characters can cause:

- "Headers already sent" errors in PHP
- Broken JSON responses
- Session/cookie failures
- Unexpected output before <?php

### 🛡️ Prevention

#### VS Code

Set encoding to UTF-8 without BOM:

```
"files.encoding": "utf8"
```

#### Git (optional)

Add .gitattributes:

```
*.php text working-tree-encoding=UTF-8
*.js text working-tree-encoding=UTF-8
*.html text working-tree-encoding=UTF-8
```

## 📜 License

MIT License

© Copyright 2026 Seyyed Ali Mohammadiyeh (Max Base)

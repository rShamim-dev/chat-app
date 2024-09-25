## Chat App

![Getting Started](/public/chat.png)

Usese Tecnology for make this Application

-   **Laravel**
-   **Livewire**
-   **Tailwind Css**
-   **Reverb**

## Install this Chat App with npm

1. Clone the repo and open directory

```bash
    git clone https://github.com/smshamimsr/chat-app.git && cd chat-app
```

2. Copy .env File

```bash
    cp .env.example .env
```

3. Composer Install

```bash
    composer install
```

4. npm install

```bash
    npm install && npm run dev
```

5. Artisan Key Generate

```bash
    php artisan key:generate
```

6. Create Database in mysql server and conect to env file
7. Migrate Database with Seed

```bash
    php artisan migrate --seed
```

8. Or if you use the sqlite then don't needed to create database because sqlite datase file is exists in database folder

9. Run the project run command

```bash
    php artisan serve
```

10. Reverb Start

```bash
    php aritsan reverb:start
```

# Teste Técnico Sunhub

Este repositório contém o backend e o frontend do teste técnico para a Sunhub.

## 🖥️ Tecnologias Utilizadas

- **Backend:** Laravel 11, Docker, Sail
- **Frontend:** Vue 3, Vite

---

## 🚀 Configuração do Backend

### Linux/macOS

1. **Renomear o arquivo de configuração:**
   ```sh
   mv .env.conf .env
   ```

2. **Criar uma nova chave da aplicação:**
   ```sh
   ./vendor/bin/sail artisan key:generate
   ```

3. **Subir os containers do Docker:**
   ```sh
   ./vendor/bin/sail up -d
   ```

4. **Executar as migrações do banco de dados:**
   ```sh
   ./vendor/bin/sail artisan migrate
   ```

### Windows

1. **Renomear o arquivo de configuração:**
   ```powershell
   Rename-Item .env.conf .env
   ```

2. **Criar uma nova chave da aplicação:**
   ```powershell
   vendor\bin\sail artisan key:generate
   ```

3. **Subir os containers do Docker:**
   ```powershell
   vendor\bin\sail up -d
   ```

4. **Executar as migrações do banco de dados:**
   ```powershell
   vendor\bin\sail artisan migrate
   ```

---

## 🎨 Configuração do Frontend

1. **Acessar a pasta do frontend:**
   ```sh
   cd frontend
   ```

2. **Instalar as dependências:**
   ```sh
   npm install
   ```

3. **Rodar o projeto:**
   ```sh
   npm run dev
   ```

---

## 📝 Observações

- Certifique-se de ter o **Docker** e o **Docker Compose** instalados e de que nenhuma outra aplicação esteja utilizando as portas configuradas no arquivo `.env`.
- O backend utiliza o **Laravel Sail**, então todos os comandos devem ser executados com `./vendor/bin/sail` no Linux/macOS ou `vendor\bin\sail` no Windows.
- O frontend utiliza **Vite**, então o projeto será acessível pela URL informada após o comando `npm run dev`.

---

Agora seu projeto está configurado e pronto para ser executado! 🚀


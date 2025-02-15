# Teste Técnico Sunhub

Este repositório contém o backend e o frontend do teste técnico para a Sunhub.

## 🖥️ Tecnologias Utilizadas

- **Backend:** Laravel 11, Docker, Sail
- **Frontend:** Vue 3, Vite

---

## 🚀 Configuração do Backend

### Linux/macOS

1. **Instalar as dependências do Composer:**

   Mude para o diretório do backend:
    ```sh
   cd backend/
   ```
   
   Instale os pacotes:
   ```sh
   composer install
   ```

1. **Criar o arquivo de configuração:**
   ```sh
   cp .env.conf .env
   ```

2. **Subir os containers do Docker:**
   ```sh
   ./vendor/bin/sail up -d
   ```


3. **Criar uma nova chave da aplicação:**
   ```sh
   ./vendor/bin/sail artisan key:generate
   ```


4. **Executar as migrações do banco de dados:**
   ```sh
   ./vendor/bin/sail artisan migrate
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

3. **Rodar o projeto em desenvolvimento:**
   ```sh
   npm run dev
   ```

---

### 🚀 Ambiente de Produção

1. **Gerar a build para produção:**
   ```sh
   npm run build
   ```

2. **Instalar um servidor estático para servir a aplicação:**
   ```sh
   npm install -g serve
   ```

3. **Rodar a aplicação em produção:**
   ```sh
   serve -s dist -l 3000
   ```

Isso disponibilizará o site em `http://localhost:3000/`.


---

## 📝 Observações


- Certifique-se de ter o **Docker** e o **Docker Compose** instalados e de que nenhuma outra aplicação esteja utilizando as portas configuradas no arquivo `.env`.


---

Agora seu projeto está configurado e pronto para ser executado.


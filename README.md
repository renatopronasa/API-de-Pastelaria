# 🥟 Pastelaria API — Docker + Laravel

API RESTful desenvolvida em **Laravel**, com **Docker** e **testes automatizados (Feature e Unit)**, para o gerenciamento de **clientes, produtos e pedidos** de uma pastelaria.

---

## 🚀 Tecnologias Utilizadas

- **Laravel 11**
- **PHP 8.2+**
- **Docker / Docker Compose**
- **MySQL**
- **PHPUnit** (Testes Unitários e de Integração)
- **Mailtrap / SMTP** (envio de e-mails simulados)

---

## 🧱 Estrutura de Módulos

### 🧍 Cliente
Campos:
- nome, e-mail, telefone, data de nascimento, endereço, complemento, bairro, cep, data de cadastro  
Regras:
- E-mail único  
- Soft delete  
- Validação completa via FormRequest  

### 🍴 Produto
Campos:
- nome, preço, foto  
Regras:
- Foto obrigatória  
- Soft delete  

### 🧾 Pedido
Campos:
- cliente_id, produtos (muitos-para-muitos), data de criação  
Regras:
- Pedido pertence a um cliente  
- Pode conter N produtos  
- Dispara e-mail de confirmação após criação  

---

## 🔗 Relacionamentos

- **Cliente → Pedido** → `1:N`
- **Pedido → Produto** → `N:N`
- **Produto → Pedido** → `N:N`

Todos os relacionamentos estão testados com **testes unitários automatizados**.

---

## 🧪 Testes

### Rodar todos os testes
```bash
php artisan test
```

### Rodar apenas Feature Tests
```bash
php artisan test --testsuite=Feature
```

### Rodar apenas Unit Tests
```bash
php artisan test --testsuite=Unit
```

> ✅ Todos os testes estão passando (clientes, produtos e pedidos).

---

## 🐳 Como Rodar com Docker

### 1️⃣ Clonar o repositório
```bash
git clone https://github.com/renatopronasa/pastelaria-api.git
cd pastelaria-api
```

### 2️⃣ Subir os containers
```bash
docker-compose up -d --build
```

### 3️⃣ Rodar as migrations e seeders
```bash
docker exec -it pastelaria-api-app php artisan migrate --seed
```

### 4️⃣ Acessar a aplicação
```
http://localhost:8000
```

---

## 📬 Envio de E-mails

Após a criação de um pedido, o sistema envia automaticamente um e-mail ao cliente com os detalhes do pedido.  
O envio é configurado para uso com **Mailtrap**, bastando definir as credenciais no arquivo `.env`.

---

## 📚 Endpoints Principais

| Método | Endpoint | Descrição |
|--------|-----------|-----------|
| GET | `/api/clientes` | Listar clientes |
| POST | `/api/clientes` | Criar cliente |
| PUT | `/api/clientes/{id}` | Atualizar cliente |
| DELETE | `/api/clientes/{id}` | Remover cliente |
| GET | `/api/produtos` | Listar produtos |
| POST | `/api/produtos` | Criar produto |
| GET | `/api/pedidos` | Listar pedidos |
| POST | `/api/pedidos` | Criar pedido |

---

## 🧹 Padrões de Código

- PSR-1, PSR-4 e PSR-12 seguidos em todo o projeto  
- Nomes de classes, métodos e rotas no padrão **camelCase**  
- Código organizado em **Controllers**, **Models**, **Requests** e **Tests**

---

## 👨‍💻 Autor

**Renato Santos**  
🔗 GitHub: [@renatopronasa](https://github.com/renatopronasa)


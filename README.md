# Pastelaria API — Docker + Laravel

API RESTful desenvolvida em **Laravel 12**, com **Docker** e **testes automatizados (Feature e Unit)**, para o gerenciamento de **clientes, produtos e pedidos** de uma pastelaria.

---

## Tecnologias Utilizadas

- **Laravel 12**
- **PHP 8.2+**
- **Docker / Docker Compose**
- **MySQL**
- **PHPUnit** (Testes Unitários e de Integração)
- **Mailtrap / SMTP** (envio de e-mails simulados)
- **Makefile** (atalhos de automação)
- **Queue / ShouldQueue** (envio de e-mails em fila)

---

## Estrutura de Módulos

### Customer
Campos:
- name, email, phone, birth_date, address, address_complement, neighborhood, zipcode, registration_date

Regras:
- Email único  
- Soft delete  
- Validação completa via FormRequest  

### Product
Campos:
- name, price, photo, type  

Regras:
- Foto obrigatória  
- Campo “tipo” define a categoria do produto  
- Soft delete  

### Order
Campos:
- customer_id, products, data_criacao  

Regras:
- Pedido pertence a um cliente  
- Pode conter vários produtos  
- Dispara e-mail de confirmação após criação  
- E-mail enviado de forma assíncrona (fila)  
- Envolvido em transação (DB::transaction) para garantir integridade  
- Soft delete  

---

## Relationships

- **Customer → Order** → `1:N`
- **Order → Product** → `N:N`
- **Product → Order** → `N:N`

---

## Como Rodar com Docker

### 1 - Clonar o repositório
```bash
git clone https://github.com/renatopronasa/pastelaria-api.git
cd pastelaria-api
```

### 2 - Subir os containers
```bash
docker-compose up -d --build
```

### 3 - Acessar o container da aplicação
```bash
docker exec -it pastelaria_app bash
```

### 4 - Rodar as migrations e seeders

Após subir os containers, execute o comando abaixo para **dentro do container da aplicação, para criar as tabelas e popular o banco de dados.**  

```bash
php artisan migrate --seed
```
---

## Testes

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
---

## Endpoints Principais (Padrão Americano)

### Customers
| Método | Endpoint | Descrição |
|--------|-----------|-----------|
| GET | `/api/customers` | Listar clientes (com paginação) |
| GET | `/api/customers/{id}` | Exibir um cliente |
| POST | `/api/customers` | Criar cliente |
| PUT | `/api/customers/{id}` | Atualizar cliente |
| DELETE | `/api/customers/{id}` | Remover cliente |

### Products
| Método | Endpoint | Descrição |
|--------|-----------|-----------|
| GET | `/api/products` | Listar produtos (com paginação) |
| GET | `/api/products/{id}` | Exibir um produto |
| POST | `/api/products` | Criar produto |
| PUT | `/api/products/{id}` | Atualizar produto |
| DELETE | `/api/products/{id}` | Remover produto |

### Orders
| Método | Endpoint | Descrição |
|--------|-----------|-----------|
| GET | `/api/orders` | Listar pedidos (com paginação) |
| GET | `/api/orders/{id}` | Exibir um pedido |
| POST | `/api/orders` | Criar pedido (com itens) |
| PUT | `/api/orders/{id}` | Atualizar pedido |
| DELETE | `/api/orders/{id}` | Remover pedido |

---

## Padrões de Código

- Padrões **PSR-1**, **PSR-4** e **PSR-12** seguidos em todo o projeto  
- Nomes de classes, métodos e rotas em **camelCase**  
- Código organizado em **Controllers**, **Models**, **Requests**, **Resources** e **Tests**  
- Respostas padronizadas via **Laravel API Resources**  
- Paginação nos endpoints de listagem  

---

## Autor

**Renato Santos**  
🔗 GitHub: [@renatopronasa](https://github.com/renatopronasa)


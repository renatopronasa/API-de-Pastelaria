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
- Email único;
- Validação completa via FormRequest;
- Suporta Soft delete.  

### Product
Campos:
- name, price, photo, type  

Regras:
- Foto obrigatória;
- O Campo “type” define a categoria do produto; 
- Suporta Soft delete.

## Relationships

- **Customer → Order** → `1:N`
- Um cliente pode ter vários pedidos;
- Cada pedido pertence a um único cliente.

- **Order → Product** → `N:N`
- Um pedido pode conter vários produtos;
- Essa relação é representada por um método orders dentro do model Product, usando belongsToMany;
- No código, essa relação é representada pelo método products no model Order.

- **Product → Order** → `N:N`

- Um produto pode estar presente em diversos pedidos diferentes;
- Essa relação também utiliza a tabela order_product, que liga produtos e pedidos e guarda informações adicionais, como quantidade;
- Exemplo prático: o mesmo produto “Pastel de Queijo” pode aparecer em vários pedidos de diferentes clientes.

### Order
Campos:
- customer_id, products, creation_date  

Regras e comportamentos:
- Dispara e-mail de confirmação após criação;  
- E-mail enviado de forma assíncrona (fila);  
- O processo de criação ocorre dentro de uma transação (DB::transaction), garantindo a integridade dos dados;
- Suporta Soft delete.  

---

## Envio de E-mails
- O envio de e-mails é feito automaticamente após a criação de um novo pedido (Order);
- Foi criado um arquivo de teste específico (MailTest.php) para validar o envio de e-mails de confirmação de pedido;
- Esse teste simula a criação de um cliente, um produto e um pedido, e verifica se o e-mail foi enviado corretamente para o cliente após a criação do pedido, garantindo o funcionamento da classe OrderCreated responsável pela notificação.

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


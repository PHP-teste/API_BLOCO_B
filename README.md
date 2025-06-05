

---

# API de Filtragem de Salas (Bloco B)

**Nota importante:** Este projeto é um **teste acadêmico** desenvolvido para um trabalho de faculdade. Não tem fins comerciais e seu código pode conter simplificações próprias de um ambiente de aprendizado.

## Pré-requisitos
- Fazer o download dos arquivos do repositório (download ZIP), após o download, extraia o arquivo ZIP;
- XAMPP instalado ([Download oficial](https://www.apachefriends.org/))

## Configuração do Banco de Dados
- Abra o XAMPP e inicie o Apache e o MySQL;
- Clique em "admin" nas opções do MySQL para abrir o PHPMyAdmin;
- Vá na aba "SQL";
- Execute estes comandos no PHPMyAdmin (XAMPP) na ordem indicada:

### 1. Criar banco de dados:
```sql
CREATE DATABASE api_bloco_b;
```
- Clique em "executar";
- Após executar esse comando, o banco de dados "api_bloco_b" será criado, será exibido à esquerda;
- Selecione-o e vá na aba "SQL" novamente;
- Execute os próximos comando nessa mesma aba;

### 2. Criar tabela de salas:
```sql
CREATE TABLE Bloco_B (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    SALA VARCHAR(35),
    ANDAR VARCHAR(5),
    ASSENTOS INT,
    MONITORES INT,
    PROJETORES INT,
    LOUSAS INT,
    MICROFONES INT
);
```
- Após executar o comando, clique novamente em "SQL" e repita o processo com os próximos comandos;

### 3. Criar tabela de usuários:
```sql
CREATE TABLE Usuarios(
    ID INT AUTO_INCREMENT PRIMARY KEY,
    NOME VARCHAR(50) NOT NULL,
    EMAIL VARCHAR(100) UNIQUE NOT NULL,
    SENHA VARCHAR(255) NOT NULL,
    TOKEN VARCHAR (32) NOT NULL,
    RECUPERACAO_SENHA VARCHAR(255) DEFAULT NULL
);
```

### 4. Inserir dados das salas:
```sql
INSERT INTO Bloco_B (SALA, ANDAR, ASSENTOS, MONITORES, PROJETORES, LOUSAS, MICROFONES) VALUES
('B300', '3º', 61, 0, 1, 1, 1),
('B301', '3º', 28, 0, 1, 1, 1),
('B302', '3º', 28, 0, 1, 1, 0),
('B303', '3º', 42, 0, 1, 1, 0),
('B304', '3º', 49, 0, 1, 1, 0),
('B305', '3º' , 50, 0, 1, 1, 0),
('B306', '3º', 58, 0, 1, 1, 0),
('B307', '3º', 49, 0, 1, 1, 0),
('B308', '3º', 57, 0, 1, 1, 0),
('B309', '3º', 50, 0, 1, 1, 0),
('B310', '3º', 43, 0, 1, 1, 0),
('B311', '3º', 49, 0, 1, 1, 0),
('B312', '3º', 50, 0, 1, 1, 0),
('B315', '3º', 22, 0, 1, 2, 0),
('B316', '3º', 16, 0, 1, 2, 0),
('B317', '3º', 30, 0, 1, 1, 0),
('B318', '3º', 28, 0, 1, 2, 0),
('B319', '3º', 23, 0, 1, 2, 0),
('B320', '3º', 18, 0, 1, 1, 0),
('B321/ B323/ B325', '3º', 75, 0, 1, 1, 1),
('B322', '3º', 30, 0, 1, 1, 0),
('B324', '3º', 27, 0, 1, 2, 0),
('B326', '3º', 12, 0, 1, 2, 0),
('B327', '3º', 53, 0, 1, 1, 0),
('B328', '3º', 20, 0, 1, 2, 0),
('B329', '3º', 35, 0, 1, 1, 1),
('B330', '3º', 25, 0, 1, 2, 0),
('B331', '3º', 45, 0, 1, 1, 0),
('B332', '3º', 18, 0, 1, 2, 0),
('B334', '3º', 24, 0, 1, 2, 0),
('B336', '3º', 34, 0, 1, 1, 1),
('B203', '2º', 70, 0, 1, 1, 0),
('B204', '2º', 70, 0, 1, 1, 0),
('B205', '2º', 60, 0, 1, 1, 0),
('B206', '2º', 54, 0, 1, 1, 0),
('B207', '2º', 60, 0, 1, 1, 0),
('B208', '2º', 56, 0, 1, 1, 0),
('B209', '2º', 00, 0, 0, 0, 0),
('B210', '2º', 58, 0, 1, 1, 0),
('B211', '2º', 59, 0, 1, 1, 0),
('B212', '2º', 63, 0, 1, 1, 0),
('B215', '2º', 60, 0, 1, 1, 0),
('B216', '2º', 56, 0, 1, 1, 0),
('B217', '2º', 55, 0, 1, 1, 0),
('B218', '2º', 55, 0, 1, 1, 0),
('B219/ B221', '2º', 83, 0, 1, 1, 1),
('B220', '2º', 55, 0, 1, 1, 0),
('B223', '2º', 74, 1, 0, 1, 1),
('B222/ B224', '2º', 111, 3, 0, 1, 1),
('B225', '2º', 54, 0, 1, 1, 0),
('B226 (C/BANCADA)', '2º', 58, 0, 1, 1, 0),
('B101', '1º', 40, 0, 1, 1, 0),
('B103/ B105', '1º', 83, 1, 0, 1, 1),
('B104', '1º', 55, 0, 1, 1, 0),
('B106', '1º', 55, 0, 1, 1, 0),
('B107', '1º', 83, 0, 1, 1, 1),
('B108', '1º', 55, 0, 1, 1, 0),
('B109', '1º', 56, 0, 1, 1, 0),
('B110', '1º', 56, 0, 1, 1, 1),
('B111', '1º', 56, 0, 1, 1, 0),
('B112', '1º', 55, 0, 1, 1, 0),
('B117', '1º', 56, 0, 1, 1, 0),
('B119', '1º', 68, 0, 1, 1, 0),
('B118/ B120/ B122/ B124', '1º', 105, 3, 0, 1, 1),
('B121/ B123', '1º', 106, 1, 0, 1, 1),
('B126/ B128', '1º', 81, 0, 1, 1, 1);
```
*(Cole todos os valores fornecidos, garantindo que não faltem vírgulas entre as linhas)*

## Configuração do XAMPP
1. Localize o arquivo `httpd.conf` (pasta `xampp/apache/conf`)
2. **Substitua** essas duas diretivas pelo caminho da pasta do projeto:
```apacheconf
DocumentRoot "C:/caminho/para/seu/projeto"
<Directory "C:/caminho/para/seu/projeto">
```
*(Exemplo válido para Windows: `"C:/Users/Usuario/projeto-api"`)*

## Execução
1. Inicie os módulos **Apache** e **MySQL** pelo painel do XAMPP
2. Acesse no navegador:  
   `http://localhost/`  
---

## Observações Adicionais
1. **Dados de exemplo**: A tabela `Usuarios` está vazia inicialmente - cadastre usuários via API conforme sua implementação
2. **Segurança**: Esta configuração é adequada apenas para ambiente local de testes
3. **Sugestão para usuários**: Recomende criar um Virtual Host para evitar conflitos com outros projetos

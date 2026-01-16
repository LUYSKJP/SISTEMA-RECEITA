# Receitas & Rotulagem ANVISA (CI3 + PHP 8.2 + MySQL 8)

Sistema web para cadastro de ingredientes e receitas, cálculo nutricional, geração de Tabela de Informação Nutricional, %VD e Rotulagem Nutricional Frontal (LUPA) conforme RDC 429/2020 + IN 75/2020. Todas as regras estão parametrizadas em tabelas para permitir versões regulatórias futuras.

## Requisitos

- PHP 8.2
- MySQL 8
- Apache (XAMPP no Windows)
- Composer (para instalar `dompdf/dompdf`)

## Instalação (XAMPP/Windows)

1. Copie o projeto para `C:\xampp\htdocs\SISTEMA-RECEITA`.
2. Crie um banco `sistema_receita` no MySQL.
3. Configure a conexão em `application/config/database.php`.
4. Execute as migrations:

```bash
php index.php migrate
```

5. Execute o seed de dados:

```bash
php index.php seed DemoSeeder
```

6. Instale o Dompdf:

```bash
composer require dompdf/dompdf
```

7. Acesse `http://localhost/SISTEMA-RECEITA`.

## Acesso inicial

Usuário admin criado pelo seed:

- **Login:** admin
- **Senha:** admin123

## Estrutura principal

- `/application/controllers` - Controladores (Auth, Ingredients, Recipes, Labels, Config).
- `/application/models` - Modelos (User, Ingredient, Recipe, Regulatory).
- `/application/views` - Views com Bootstrap 5.
- `/database/migrations` - Migrations de tabelas.
- `/database/seeds` - Seeders de dados (10 ingredientes + 1 receita).
- `/public/assets` - CSS/JS.

## Configuração regulatória

Todas as regras são parametrizadas por versão em:

- `regulatory_versions`
- `vdr_values`
- `fop_thresholds`
- `label_rounding_rules`

Crie novas versões (ex.: `RDC429_IN75_v2`) e edite a tela **Config ANVISA** para atualizar limites/valores sem alterar código.

## Exportações

- **PDF**: `dompdf/dompdf`.
- **SVG/PNG**: geração pelo endpoint de rótulo com dimensões configuráveis em **Config ANVISA**.

## Observações

- A tabela nutricional inclui porção, por 100 g/100 ml e %VD.
- A lupa é gerada automaticamente quando algum nutriente excede o limite configurado na versão regulatória ativa.
- Regras de arredondamento e quantidades não significativas são aplicadas conforme tabela `label_rounding_rules`.

# Integração MVC - Perfil do Usuário

## Estrutura da Integração

```
Pages/perfilUsuarios.php (ENTRADA)
    ↓
    ├─ Valida autenticação (session)
    ├─ Obtém ID da empresa
    └─ Instancia PerfilController
         ↓
    Controller/PerfilController.php
         ├─ Valida ID
         └─ Chama Model
              ↓
    Model/PerfilModel.php
         ├─ getEmpresaById() → Busca empresa na DB
         ├─ getHistoricoSimulacoes() → Busca histórico
         └─ getPerfilCompleto() → Retorna tudo junto
              ↓
    View/PerfilView.php (SAÍDA)
         └─ Renderiza HTML com os dados
```

## Fluxo de Dados

1. **perfilUsuarios.php** - Valida sessão e prepara os dados
   - Obtém `empresa_id` da sessão
   - Cria instância de `PerfilController`
   - Chama `obterPerfilCompleto($empresaId)`
   - Extrai `$empresa` e `$historico`

2. **PerfilController.php** - Valida e processa
   - Valida se ID é numérico
   - Chama `PerfilModel->getPerfilCompleto()`
   - Retorna array com dados

3. **PerfilModel.php** - Busca dados do banco
   - `getEmpresaById()` - SELECT da tabela empresas
   - `getHistoricoSimulacoes()` - JOIN com simulacoes, cidades, form_empresa
   - `getPerfilCompleto()` - Retorna tudo junto

4. **PerfilView.php** - Renderiza a página
   - Recebe `$empresa` e `$historico`
   - Exibe ID, Nome, Email, CNPJ
   - Mostra tabela com histórico de simulações

## Como Usar

### Teste Local
```bash
# Abra no navegador:
http://localhost/Viabilidade-WYT/teste-perfil.php
```

### Em Produção
Certifique-se que o usuário está autenticado e sua session tem:
```php
$_SESSION['empresa_id'] = ID_DA_Empresa;
// ou
$_SESSION['id_empresa'] = ID_DA_Empresa;
// ou
$_SESSION['user_id'] = ID_DA_Empresa;
```

Depois acesse:
```
http://localhost/Viabilidade-WYT/Pages/perfilUsuarios.php
```

## Variáveis da View

O PerfilView.php espera receber:

```php
$empresa = [
    'id' => int,
    'nome' => string,
    'email' => string,
    'cnpj' => string
];

$historico = [
    [
        'id' => int,
        'cidade_nome' => string,
        'quant_ancoras' => int,
        'tipo_comercio' => string,
        'investimento' => decimal,
        'valor_medio_produto' => decimal,
        'publico_etario' => string,
        'publico_economico' => string,
        'probabilidade_sucesso' => percentage,
        'renda_mensal' => decimal,
        'break_even' => int
    ],
    // ... mais simulações
];
```

## Funcionalidades

✅ Exibir dados da empresa (ID, Nome, Email, CNPJ)
✅ Mostrar histórico de simulações em tabela
✅ Escapar HTML (XSS protection)
✅ Responsivo (mobile + desktop)
✅ Imprimir histórico (Ctrl+P)
✅ Validação de autenticação
✅ Tratamento de erros (perfil não encontrado)

## Estrutura de Tabelas Esperada

```sql
-- Tabelas que o código consulta:
empresas (id, nome, email, cnpj)
simulacoes (id, empresa_id, cidade_id, form_empresa_id, probabilidade_sucesso, renda_mensal, break_even)
cidades (id, nome)
form_empresa (id, tipo_comercio, valor_medio_produto, publico_etario, publico_economico, quant_ancoras, investimento)
```

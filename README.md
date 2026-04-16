# Portal institucional da Ádige Ambientes

Site em PHP com páginas institucionais, páginas internas por ambiente e captação de leads.

## Arquivos essenciais para rodar

- `index.php`: home
- `ambiente.php`: página interna dinâmica por ambiente (`?slug=...`)
- `site-data.php`: conteúdo central da marca e ambientes
- `contact.php`: endpoint de envio de lead
- `admin.php`: painel para editar conteúdo JSON e enviar imagens
- `style.css`: estilos e responsividade
- `app.js`: interações (menu mobile, animações, depoimentos e formulário)
- `assets/`: imagens do site
- `data/.gitkeep`: garante a pasta de conteúdo customizado versionada

## Como executar localmente

Requisito: PHP 8+.

```bash
php -S 127.0.0.1:8000 -t .
```

Acesse:

- Home: `http://127.0.0.1:8000/`
- Painel admin: `http://127.0.0.1:8000/admin.php`

## Configurações por variável de ambiente

### Leads (e-mail/CRM)

- `ADIGE_LEAD_EMAIL_TO`
- `ADIGE_LEAD_EMAIL_FROM`
- `ADIGE_MAIL_SUBJECT_PREFIX`
- `ADIGE_CRM_WEBHOOK_URL`
- `ADIGE_CRM_WEBHOOK_TOKEN`

### Painel admin

- `ADIGE_ADMIN_PASSWORD` (recomendado definir em produção)

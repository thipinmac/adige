<?php

declare(strict_types=1);

require __DIR__ . '/site-data.php';

$slug = (string) ($_GET['slug'] ?? '');
$environment = find_environment($site, $slug);

if ($environment === null) {
    http_response_code(404);
    $environment = $site['environments'][0];
}

$related = array_values(array_filter(
    $site['environments'],
    static fn(array $item): bool => $item['slug'] !== $environment['slug']
));
$related = array_slice($related, 0, 3);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= h($environment['name']); ?> | <?= h($site['brand']['name']); ?></title>
    <meta name="description" content="<?= h($environment['summary']); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600&family=Cormorant+Garamond:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="theme-official theme-inner">
    <header class="site-header">
        <nav class="site-nav container">
            <a href="index.php#hero" class="nav-logo" aria-label="<?= h($site['brand']['name']); ?>">
                <img src="<?= h($site['brand']['logo']); ?>" alt="<?= h($site['brand']['name']); ?>" class="logo-img">
            </a>

            <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="site-menu">
                <span></span>
                <span></span>
            </button>

            <div class="nav-menu" id="site-menu">
                <a href="index.php#sobre">Sobre</a>
                <a href="index.php#ambientes">Ambientes</a>
                <a href="index.php#portfolio">Portfólio</a>
                <a href="index.php#contato">Contato</a>
                <a href="#contato-ambiente" class="nav-cta">Solicitar Orçamento</a>
            </div>
        </nav>
    </header>

    <main>
        <section class="inner-hero">
            <div class="container inner-hero-grid">
                <div class="inner-copy" data-reveal="up">
                    <a href="index.php#ambientes" class="breadcrumb">Ambientes</a>
                    <span class="label"><?= h($environment['name']); ?></span>
                    <h1 class="heading"><?= h($environment['headline']); ?></h1>
                    <p class="copy"><?= h($environment['description']); ?></p>

                    <div class="pillars">
                        <?php foreach ($environment['pillars'] as $pillar): ?>
                            <span><?= h($pillar); ?></span>
                        <?php endforeach; ?>
                    </div>

                    <div class="hero-btns">
                        <a href="#contato-ambiente" class="btn-solid">Solicitar Orçamento</a>
                        <a href="<?= h($site['brand']['phone_link']); ?>" class="btn-outline btn-outline-dark" target="_blank" rel="noreferrer">Falar no WhatsApp</a>
                    </div>
                </div>

                <div class="inner-visual" data-reveal="left">
                    <img src="<?= h($environment['image']); ?>" alt="<?= h($environment['name']); ?>" class="inner-main-image">
                    <img src="<?= h($environment['secondary_image']); ?>" alt="<?= h($environment['name']); ?>" class="inner-secondary-image">
                </div>
            </div>
        </section>

        <section class="section-light">
            <div class="container detail-grid">
                <article class="detail-card" data-reveal="up">
                    <span class="label">Visão do projeto</span>
                    <h2 class="heading">Solução pensada para <em><?= h($environment['name']); ?></em></h2>
                    <p class="copy"><?= h($environment['summary']); ?></p>
                    <p class="copy">
                        O objetivo desta página é aprofundar o discurso comercial do ambiente, responder objeções com mais
                        clareza e conduzir o cliente para um pedido de orçamento mais qualificado.
                    </p>
                </article>

                <article class="detail-card" data-reveal="up">
                    <span class="label">O que a Ádige entrega</span>
                    <ul class="feature-list">
                        <li>Leitura técnica do espaço e da rotina do cliente.</li>
                        <li>Escolha criteriosa de acabamentos, ferragens e composição visual.</li>
                        <li>Execução e instalação acompanhadas pela equipe da Ádige.</li>
                        <li>Garantia e pós-entrega alinhados ao padrão da marca.</li>
                    </ul>
                </article>
            </div>
        </section>

        <section class="process-section compact-process">
            <div class="container">
                <div class="section-header center" data-reveal="up">
                    <span class="label lt">Jornada do ambiente</span>
                    <h2 class="heading wh">Da ideia à <em>instalação</em></h2>
                </div>

                <div class="steps-grid">
                    <?php foreach ($site['steps'] as $index => $step): ?>
                        <article class="step" data-reveal="up" style="--delay: <?= $index; ?>;">
                            <span class="step-num"><?= h($step['number']); ?></span>
                            <h3 class="step-title"><?= h($step['title']); ?></h3>
                            <p class="step-text"><?= h($step['text']); ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="related-section">
            <div class="container">
                <div class="section-header" data-reveal="up">
                    <span class="label">Outros ambientes</span>
                    <h2 class="heading">Continue explorando o <em>portfólio Ádige.</em></h2>
                </div>

                <div class="related-grid">
                    <?php foreach ($related as $index => $item): ?>
                        <article class="related-card" data-reveal="up" style="--delay: <?= $index; ?>;">
                            <img src="<?= h($item['image']); ?>" alt="<?= h($item['name']); ?>">
                            <div class="related-content">
                                <h3><?= h($item['name']); ?></h3>
                                <p><?= h($item['summary']); ?></p>
                                <a href="<?= h(environment_url($item)); ?>" class="link-arrow">Ver página</a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section id="contato-ambiente" class="contact-section">
            <div class="contact-grid">
                <div class="ct-info" data-reveal="up">
                    <span class="label lt">Solicite seu projeto</span>
                    <h2 class="heading wh"><?= h($environment['name']); ?> com a <em>identidade Ádige.</em></h2>
                    <div class="rule"></div>
                    <p class="ct-desc">
                        Preencha o formulário para receber atendimento com foco neste ambiente. O lead será salvo, enviado
                        por e-mail para a equipe e, se configurado, encaminhado ao CRM automaticamente.
                    </p>
                    <div class="ct-row"><div class="ct-icon">✆</div><span><?= h($site['brand']['phone']); ?></span></div>
                    <div class="ct-row"><div class="ct-icon">✉</div><span><?= h($site['brand']['email']); ?></span></div>
                    <div class="ct-row"><div class="ct-icon">IG</div><span><?= h($site['brand']['instagram_handle']); ?></span></div>
                </div>

                <div class="ct-form" data-reveal="left">
                    <form class="lead-form" action="contact.php" method="post">
                        <input type="hidden" name="environment" value="<?= h($environment['name']); ?>">
                        <div class="fg-row">
                            <div class="fg">
                                <label>Nome</label>
                                <input type="text" name="name" placeholder="Seu nome completo" required>
                            </div>
                            <div class="fg">
                                <label>Telefone</label>
                                <input type="tel" name="phone" placeholder="(63) 9 0000-0000" required>
                            </div>
                        </div>
                        <div class="fg-row">
                            <div class="fg">
                                <label>E-mail</label>
                                <input type="email" name="email" placeholder="seu@email.com" required>
                            </div>
                            <div class="fg">
                                <label>Mensagem</label>
                                <input type="text" name="message" placeholder="Conte rapidamente o que você deseja">
                            </div>
                        </div>
                        <button type="submit" class="btn-submit">Receber atendimento para <?= h($environment['menu_label']); ?></button>
                        <div class="form-success" role="status" aria-live="polite"></div>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <footer class="site-footer">
        <div class="footer-inner container">
            <a href="index.php#hero" aria-label="<?= h($site['brand']['name']); ?>">
                <img src="<?= h($site['brand']['logo']); ?>" alt="<?= h($site['brand']['name']); ?>" class="footer-logo-img">
            </a>
            <span class="f-copy">© 2026 <?= h($site['brand']['name']); ?> · Todos os direitos reservados</span>
            <div class="f-social">
                <a href="<?= h($site['brand']['instagram']); ?>" target="_blank" rel="noreferrer">IG</a>
                <a href="<?= h($site['brand']['phone_link']); ?>" target="_blank" rel="noreferrer">WA</a>
                <a href="mailto:<?= h($site['brand']['email']); ?>">✉</a>
            </div>
        </div>
    </footer>

    <script src="app.js"></script>
</body>
</html>

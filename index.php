<?php

declare(strict_types=1);

require __DIR__ . '/site-data.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= h($site['brand']['title']); ?></title>
    <meta name="description" content="<?= h($site['brand']['description']); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600&family=Cormorant+Garamond:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="theme-official">
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
                <a href="index.php#depoimentos">Depoimentos</a>
                <a href="index.php#faq">FAQ</a>
                <a href="index.php#contato">Contato</a>
                <a href="index.php#contato" class="nav-cta">Solicitar Orçamento</a>
            </div>
        </nav>
    </header>

    <main>
        <section id="hero" class="hero-section">
            <div class="hero-grid">
                <div class="hero-left" data-reveal="up">
                    <p class="hero-tag"><?= h($site['home']['hero_tag']); ?></p>
                    <h1 class="hero-title"><?= $site['home']['hero_title_html']; ?></h1>
                    <p class="hero-desc"><?= $site['home']['hero_desc']; ?></p>
                    <div class="hero-btns">
                        <a href="index.php#portfolio" class="btn-solid">Ver Portfólio</a>
                        <a href="index.php#contato" class="btn-outline">Orçamento Gratuito</a>
                    </div>

                    <div class="hero-metrics">
                        <?php foreach ($site['hero_metrics'] as $metric): ?>
                            <div class="metric-card">
                                <strong><?= h($metric['value']); ?></strong>
                                <span><?= h($metric['label']); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="hero-right" data-reveal="left">
                    <img class="hero-img-el" src="assets/hero.jpg" alt="Ambiente planejado de alto padrão">
                    <div class="hero-badge">
                        <strong>5 anos</strong>
                        <span>de garantia em cada projeto</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="ribbon">
            <div class="ribbon-track">
                <?php foreach (array_merge($site['environments'], $site['environments']) as $environment): ?>
                    <span><?= h($environment['name']); ?></span>
                <?php endforeach; ?>
            </div>
        </section>

        <section id="sobre" class="about-section">
            <div class="about-grid container">
                <div class="about-visual" data-reveal="left">
                    <img src="assets/sobre-main.jpg" alt="Projeto de ambiente sofisticado" class="about-main-img">
                    <img src="assets/sobre-accent.jpg" alt="Detalhe de mobiliário planejado" class="about-accent-img">
                </div>

                <div class="about-content" data-reveal="up">
                    <span class="label"><?= h($site['home']['about_label']); ?></span>
                    <h2 class="heading"><?= $site['home']['about_title_html']; ?></h2>
                    <div class="rule"></div>

                    <?php foreach ($site['home']['about_paragraphs'] as $paragraph): ?>
                        <p class="copy"><?= $paragraph; ?></p>
                    <?php endforeach; ?>

                    <div class="team-list">
                        <?php foreach ($site['team'] as $member): ?>
                            <article class="team-item">
                                <div class="team-av"><?= h($member['initials']); ?></div>
                                <div>
                                    <span class="team-name"><?= h($member['name']); ?></span>
                                    <span class="team-role"><?= h($member['role']); ?></span>
                                    <span class="team-role"><?= h($member['email']); ?></span>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>

        <section id="ambientes" class="environments-section">
            <div class="container">
                <div class="section-header center" data-reveal="up">
                    <span class="label">Ambientes</span>
                    <h2 class="heading">Páginas internas para cada <em>tipo de projeto.</em></h2>
                    <p class="copy centered-copy">
                        Cada ambiente ganhou uma página dedicada para aprofundar argumentos de venda, detalhar benefícios
                        e facilitar o funil de conversão.
                    </p>
                    <div class="environment-jump">
                        <label for="environment-select" class="environment-jump-label">Acesso rápido por ambiente</label>
                        <select id="environment-select" class="environment-jump-select" data-env-jump>
                            <option value="">Selecione um ambiente</option>
                            <?php foreach ($site['environments'] as $environment): ?>
                                <option value="<?= h(environment_url($environment)); ?>"><?= h($environment['menu_label']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="environment-grid">
                    <?php foreach ($site['environments'] as $index => $environment): ?>
                        <article class="environment-card" data-reveal="up" style="--delay: <?= $index; ?>;">
                            <img src="<?= h($environment['image']); ?>" alt="<?= h($environment['name']); ?>" class="environment-thumb">
                            <div class="environment-content">
                                <span class="environment-kicker"><?= h($environment['name']); ?></span>
                                <h3><?= h($environment['headline']); ?></h3>
                                <p><?= h($environment['summary']); ?></p>
                                <a href="<?= h(environment_url($environment)); ?>" class="link-arrow">Conhecer ambiente</a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section id="diferenciais" class="differentials-section">
            <div class="container">
                <div class="section-header center" data-reveal="up">
                    <span class="label">Nosso Diferencial</span>
                    <h2 class="heading">Com a Ádige, seus sonhos <em>saem do papel.</em></h2>
                </div>

                <div class="dif-grid">
                    <?php foreach ($site['differentials'] as $index => $item): ?>
                        <article class="dif-card" data-reveal="up" style="--delay: <?= $index; ?>;">
                            <span class="dif-icon"><?= h($item['icon']); ?></span>
                            <h3 class="dif-title"><?= h($item['title']); ?></h3>
                            <p class="dif-text"><?= h($item['text']); ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section id="processo" class="process-section">
            <div class="container">
                <div class="section-header center" data-reveal="up">
                    <span class="label lt">Plano de Projeto</span>
                    <h2 class="heading wh">Como <em>funciona</em></h2>
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

        <section id="portfolio" class="portfolio-section">
            <div class="container">
                <div class="section-header" data-reveal="up">
                    <span class="label">Portfólio</span>
                    <h2 class="heading">Projetos que <em>inspiram.</em></h2>
                </div>

                <div class="port-grid">
                    <?php foreach ($site['portfolio'] as $project): ?>
                        <article class="port-item" data-reveal="up">
                            <img class="port-bg" src="<?= h($project['image']); ?>" alt="<?= h($project['name']); ?>">
                            <div class="port-overlay">
                                <p class="port-cat"><?= h($project['type']); ?></p>
                                <h3 class="port-name"><?= h($project['name']); ?></h3>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section id="depoimentos" class="testimonials-section">
            <div class="container">
                <div class="section-header center" data-reveal="up">
                    <span class="label">Depoimentos</span>
                    <h2 class="heading">O que nossos clientes <em>dizem sobre nós.</em></h2>
                </div>

                <div class="testimonial-stage" data-reveal="up">
                    <?php foreach ($site['testimonials'] as $index => $item): ?>
                        <article class="depo-card<?= $index === 0 ? ' is-active' : ''; ?>" data-testimonial="<?= $index; ?>">
                            <span class="depo-quote">"</span>
                            <div class="depo-stars">★★★★★</div>
                            <p class="depo-text"><?= h($item['quote']); ?></p>
                            <div class="depo-author">
                                <div class="depo-av"><?= h($item['initials']); ?></div>
                                <div>
                                    <span class="depo-name"><?= h($item['author']); ?></span>
                                    <span class="depo-city"><?= h($item['location']); ?></span>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>

                    <div class="testimonial-dots">
                        <?php foreach ($site['testimonials'] as $index => $item): ?>
                            <button type="button" class="testimonial-dot<?= $index === 0 ? ' is-active' : ''; ?>" data-dot="<?= $index; ?>" aria-label="Exibir depoimento <?= $index + 1; ?>"></button>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>

        <section id="faq" class="faq-section">
            <div class="container">
                <div class="section-header center" data-reveal="up">
                    <span class="label">FAQ</span>
                    <h2 class="heading">Perguntas <em>frequentes.</em></h2>
                    <p class="copy centered-copy">
                        Reunimos respostas objetivas para dúvidas comuns sobre prazos, atendimento e andamento dos projetos.
                    </p>
                </div>

                <div class="faq-list" data-reveal="up">
                    <?php foreach ($site['faqs'] as $faq): ?>
                        <details class="faq-item">
                            <summary>
                                <span><?= h($faq['question']); ?></span>
                                <span class="faq-icon" aria-hidden="true"></span>
                            </summary>
                            <p><?= h($faq['answer']); ?></p>
                        </details>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section id="contato" class="contact-section">
            <div class="contact-grid">
                <div class="ct-info" data-reveal="up">
                    <span class="label lt">Contato</span>
                    <h2 class="heading wh">Vamos criar seu <em>ambiente ideal.</em></h2>
                    <div class="rule"></div>
                    <p class="ct-desc">
                        Preencha o formulário e enviaremos seu lead para a equipe comercial por e-mail. Se o webhook do
                        CRM estiver configurado no servidor, o mesmo lead também será encaminhado automaticamente.
                    </p>
                    <div class="ct-row"><div class="ct-icon">✆</div><span><?= h($site['brand']['phone']); ?></span></div>
                    <div class="ct-row"><div class="ct-icon">✉</div><span><?= h($site['brand']['email']); ?></span></div>
                    <div class="ct-row"><div class="ct-icon">IG</div><span><?= h($site['brand']['instagram_handle']); ?></span></div>
                    <div class="ct-row"><div class="ct-icon">WEB</div><span><?= h(parse_url($site['brand']['website'], PHP_URL_HOST) ?? $site['brand']['website']); ?></span></div>
                </div>

                <div class="ct-form" data-reveal="left">
                    <form id="lead-form" class="lead-form" action="contact.php" method="post">
                        <div class="fg-row">
                            <div class="fg">
                                <label for="lead-name">Nome</label>
                                <input id="lead-name" type="text" name="name" placeholder="Seu nome completo" required>
                            </div>
                            <div class="fg">
                                <label for="lead-phone">Telefone</label>
                                <input id="lead-phone" type="tel" name="phone" placeholder="(63) 9 0000-0000" required>
                            </div>
                        </div>
                        <div class="fg-row">
                            <div class="fg">
                                <label for="lead-email">E-mail</label>
                                <input id="lead-email" type="email" name="email" placeholder="seu@email.com" required>
                            </div>
                            <div class="fg">
                                <label for="lead-environment">Ambiente de interesse</label>
                                <select id="lead-environment" name="environment" required>
                                    <option value="">Selecione o ambiente</option>
                                    <?php foreach ($site['environments'] as $environment): ?>
                                        <option value="<?= h($environment['name']); ?>"><?= h($environment['menu_label']); ?></option>
                                    <?php endforeach; ?>
                                    <option value="Projeto Completo">Projeto Completo</option>
                                </select>
                            </div>
                        </div>
                        <div class="fg">
                            <label for="lead-message">Mensagem</label>
                            <textarea id="lead-message" name="message" placeholder="Conte um pouco sobre o seu projeto..." rows="5"></textarea>
                        </div>
                        <button type="submit" class="btn-submit">Solicitar Orçamento Gratuito</button>
                        <div class="form-success" id="form-status" role="status" aria-live="polite"></div>
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

    <a href="<?= h($site['brand']['phone_link']); ?>" class="wa-btn" target="_blank" rel="noreferrer" aria-label="WhatsApp">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
        </svg>
    </a>

    <script src="app.js"></script>
</body>
</html>

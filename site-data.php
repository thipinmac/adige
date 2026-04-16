<?php

declare(strict_types=1);

function h(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

$site = [
    'brand' => [
        'name' => 'Ádige Ambientes',
        'title' => 'Ádige Ambientes - Móveis Planejados de Alto Padrão',
        'tagline' => 'Ambientes que contam a sua história.',
        'description' => 'Transformamos ambientes residenciais e comerciais em espaços únicos e funcionais, unindo estética, praticidade e acabamento impecável.',
        'phone' => '(63) 99961-3723',
        'phone_link' => 'https://wa.me/5563999613723',
        'email' => 'contato@adige.com.br',
        'instagram' => 'https://instagram.com/adigeambientes',
        'instagram_handle' => '@adigeambientes',
        'website' => 'https://www.adige.com.br',
        'logo' => 'assets/logo.png',
    ],
    'home' => [
        'hero_tag' => 'Móveis Planejados de Alto Padrão',
        'hero_title_html' => "Ambientes que<br>contam a sua<br><em>história.</em>",
        'hero_desc' => 'Transformamos ambientes residenciais e comerciais em espaços únicos e funcionais, unindo estética, praticidade e acabamento impecável. Do planejamento à instalação.',
        'about_label' => 'Sobre nós',
        'about_title_html' => 'Sofisticação e <em>exclusividade</em><br>em cada detalhe.',
        'about_paragraphs' => [
            'A Ádige Ambientes é especializada na fabricação de móveis planejados de alto padrão, com foco em design sofisticado e personalizado. Transformamos ambientes residenciais e comerciais em espaços únicos e funcionais, unindo estética e praticidade.',
            'Com acabamento impecável e atenção a cada detalhe, utilizamos materiais de alta qualidade e soluções inovadoras, acompanhando cada etapa do projeto do planejamento à instalação final.',
        ],
    ],
    'team' => [
        [
            'initials' => 'TP',
            'name' => 'Thiago Pinheiro Maciel',
            'role' => 'Diretor de Execução e Planejamento',
            'email' => 'thiago@adige.com.br',
        ],
        [
            'initials' => 'MA',
            'name' => 'Melina Amaral Brito',
            'role' => 'Diretora de Projetos e Administrativo/Financeiro',
            'email' => 'melina@adige.com.br',
        ],
    ],
    'hero_metrics' => [
        ['value' => '5 anos', 'label' => 'de garantia em cada projeto'],
        ['value' => '20+', 'label' => 'projetos entregues'],
        ['value' => '24h', 'label' => 'para retorno inicial'],
    ],
    'differentials' => [
        [
            'icon' => '✦',
            'title' => '5 Anos de Garantia',
            'text' => 'Materiais de alto padrão com durabilidade comprovada e confiança estendida em cada projeto entregue.',
        ],
        [
            'icon' => '⟶',
            'title' => 'Entrega Rápida',
            'text' => 'Logística própria, equipe treinada e acompanhamento rigoroso para preservar prazo e acabamento.',
        ],
        [
            'icon' => '◎',
            'title' => 'Direto com a Loja',
            'text' => 'Atendimento humanizado, leitura precisa do briefing e condições alinhadas ao perfil de cada cliente.',
        ],
        [
            'icon' => '◈',
            'title' => 'Segurança Total',
            'text' => 'Processos automatizados, validação técnica e conferência final conjunta em todos os itens contratados.',
        ],
    ],
    'steps' => [
        [
            'number' => '01',
            'title' => 'Contato e identificação',
            'text' => 'Recebemos seu contato e identificamos se a demanda é um ambiente específico ou um projeto completo.',
        ],
        [
            'number' => '02',
            'title' => 'Desenvolvimento',
            'text' => 'Elaboramos o orçamento ou iniciamos os estudos preliminares do projeto de design de interiores.',
        ],
        [
            'number' => '03',
            'title' => 'Proposta',
            'text' => 'Apresentamos a proposta para análise, ajustes e aprovação de todos os itens e acabamentos.',
        ],
        [
            'number' => '04',
            'title' => 'Contrato',
            'text' => 'Formalizamos valores, condições de pagamento, cronograma e garantias do projeto.',
        ],
        [
            'number' => '05',
            'title' => 'Análise in loco',
            'text' => 'Realizamos visita técnica com todas as medições necessárias antes de iniciar a fabricação.',
        ],
        [
            'number' => '06',
            'title' => 'Instalação e conclusão',
            'text' => 'Iniciamos a instalação com conferência final conjunta de todos os itens contratados.',
        ],
    ],
    'testimonials' => [
        [
            'quote' => 'Do projeto à instalação, tudo foi impecável. A equipe da Ádige entendeu exatamente o que eu queria para minha cozinha. O resultado superou todas as minhas expectativas.',
            'author' => 'Ana Mendes',
            'location' => 'Palmas - TO',
            'initials' => 'AM',
        ],
        [
            'quote' => 'Transformaram meu apartamento completamente. O closet ficou funcional, lindo e com acabamento de altíssima qualidade. Super recomendo.',
            'author' => 'Ricardo Carvalho',
            'location' => 'Palmas - TO',
            'initials' => 'RC',
        ],
        [
            'quote' => 'Profissionalismo e pontualidade do início ao fim. Escolher a Ádige foi a melhor decisão que tomei na reforma da minha casa.',
            'author' => 'Luciana Ferreira',
            'location' => 'Palmas - TO',
            'initials' => 'LF',
        ],
    ],
    'faqs' => [
        [
            'question' => 'Quanto tempo leva para receber o orçamento inicial?',
            'answer' => 'Após o envio do formulário, nosso time comercial retorna em até 24 horas úteis com o atendimento inicial e próximos passos do projeto.',
        ],
        [
            'question' => 'Vocês atendem apenas em Palmas - TO?',
            'answer' => 'Nossa base é em Palmas - TO, mas avaliamos atendimentos em cidades próximas para projetos residenciais e comerciais de alto padrão.',
        ],
        [
            'question' => 'A visita técnica está inclusa no processo?',
            'answer' => 'Sim. Após alinhamento e avanço da proposta, realizamos análise in loco para validar medidas, pontos técnicos e acabamentos.',
        ],
        [
            'question' => 'É possível contratar um projeto completo com vários ambientes?',
            'answer' => 'Sim. Desenvolvemos projetos completos integrando diferentes ambientes, com cronograma e escopo alinhados desde o início.',
        ],
    ],
    'portfolio' => [
        ['type' => 'Sala de Estar', 'name' => 'Residência Jardins', 'image' => 'assets/portfolio-1.jpg'],
        ['type' => 'Dormitório', 'name' => 'Suíte Master', 'image' => 'assets/portfolio-2.jpg'],
        ['type' => 'Cozinha', 'name' => 'Cozinha Gourmet', 'image' => 'assets/portfolio-3.jpg'],
        ['type' => 'Home Office', 'name' => 'Escritório Planejado', 'image' => 'assets/portfolio-4.jpg'],
        ['type' => 'Closet', 'name' => 'Closet Panorâmico', 'image' => 'assets/portfolio-5.jpg'],
    ],
    'environments' => [
        [
            'slug' => 'cozinhas',
            'name' => 'Cozinhas',
            'menu_label' => 'Cozinhas',
            'headline' => 'Cozinhas planejadas para viver melhor todos os dias.',
            'summary' => 'Soluções que equilibram ergonomia, circulação e materiais de alta performance para uma rotina elegante e funcional.',
            'description' => 'Projetos de cozinha pensados para integrar estética, praticidade e armazenamento inteligente, com leitura precisa da rotina da casa e acabamento de alto padrão.',
            'image' => 'assets/portfolio-3.jpg',
            'secondary_image' => 'assets/hero.jpg',
            'pillars' => ['Funcionalidade diária', 'Acabamentos sofisticados', 'Aproveitamento de espaço'],
        ],
        [
            'slug' => 'dormitorios',
            'name' => 'Dormitórios',
            'menu_label' => 'Dormitórios',
            'headline' => 'Dormitórios que acolhem, organizam e valorizam o descanso.',
            'summary' => 'Armários, painéis e composições personalizados para conforto visual e rotina mais leve.',
            'description' => 'A Ádige desenvolve dormitórios planejados com foco em conforto, organização e identidade estética, criando espaços que traduzem o estilo de quem vive ali.',
            'image' => 'assets/portfolio-2.jpg',
            'secondary_image' => 'assets/sobre-main.jpg',
            'pillars' => ['Conforto visual', 'Organização sob medida', 'Composição elegante'],
        ],
        [
            'slug' => 'home-office',
            'name' => 'Home Office',
            'menu_label' => 'Home Office',
            'headline' => 'Home office com produtividade, foco e presença visual.',
            'summary' => 'Estações de trabalho desenhadas para ergonomia, tecnologia e boa apresentação do ambiente.',
            'description' => 'Projetamos espaços de trabalho residenciais e corporativos com soluções inteligentes para equipamentos, armazenamento, iluminação e conforto.',
            'image' => 'assets/portfolio-4.jpg',
            'secondary_image' => 'assets/hero.jpg',
            'pillars' => ['Ergonomia', 'Organização tecnológica', 'Presença profissional'],
        ],
        [
            'slug' => 'salas',
            'name' => 'Sala de Estar e TV',
            'menu_label' => 'Sala de Estar / TV',
            'headline' => 'Salas planejadas para conviver, relaxar e impressionar.',
            'summary' => 'Painéis, racks, adegas e composições integradas para valorizar o ambiente social da casa.',
            'description' => 'As salas planejadas da Ádige unem sofisticação, fluidez e funcionalidade, com soluções personalizadas para receber, descansar e destacar o design do espaço.',
            'image' => 'assets/portfolio-1.jpg',
            'secondary_image' => 'assets/sobre-main.jpg',
            'pillars' => ['Convívio', 'Integração estética', 'Detalhes sob medida'],
        ],
        [
            'slug' => 'closets',
            'name' => 'Closets',
            'menu_label' => 'Closets',
            'headline' => 'Closets que transformam organização em experiência.',
            'summary' => 'Compartimentação inteligente, iluminação e acabamentos que elevam o uso cotidiano.',
            'description' => 'Closets desenhados para acomodar com elegância roupas, calçados e acessórios, valorizando a rotina com visual refinado e máxima funcionalidade.',
            'image' => 'assets/portfolio-5.jpg',
            'secondary_image' => 'assets/sobre-accent.jpg',
            'pillars' => ['Setorização inteligente', 'Sofisticação', 'Uso intuitivo'],
        ],
        [
            'slug' => 'banheiros',
            'name' => 'Banheiros',
            'menu_label' => 'Banheiros',
            'headline' => 'Banheiros planejados com leveza, resistência e elegância.',
            'summary' => 'Mobiliário pensado para umidade, organização e sensação de bem-estar em cada detalhe.',
            'description' => 'Criamos banheiros planejados com materiais adequados, linhas limpas e soluções discretas para armazenamento, apoio e acabamento refinado.',
            'image' => 'assets/sobre-accent.jpg',
            'secondary_image' => 'assets/portfolio-2.jpg',
            'pillars' => ['Resistência', 'Estética limpa', 'Praticidade'],
        ],
        [
            'slug' => 'area-de-servico',
            'name' => 'Área de Serviço',
            'menu_label' => 'Área de Serviço',
            'headline' => 'Área de serviço organizada para uma rotina mais fluida.',
            'summary' => 'Planejamento técnico para lavanderias funcionais, discretas e visualmente integradas.',
            'description' => 'A Ádige projeta áreas de serviço com foco em ergonomia, circulação e armazenamento, mantendo ordem visual e praticidade de uso.',
            'image' => 'assets/hero.jpg',
            'secondary_image' => 'assets/portfolio-4.jpg',
            'pillars' => ['Organização', 'Circulação', 'Resolução técnica'],
        ],
        [
            'slug' => 'varandas',
            'name' => 'Varandas',
            'menu_label' => 'Varandas',
            'headline' => 'Varandas planejadas para receber com conforto e estilo.',
            'summary' => 'Ambientes acolhedores com marcenaria sob medida para momentos de convívio e relaxamento.',
            'description' => 'Projetamos varandas e espaços gourmet com soluções que combinam resistência, funcionalidade e identidade visual marcante.',
            'image' => 'assets/portfolio-1.jpg',
            'secondary_image' => 'assets/portfolio-3.jpg',
            'pillars' => ['Convívio', 'Durabilidade', 'Estilo'],
        ],
        [
            'slug' => 'projetos-comerciais',
            'name' => 'Projetos Comerciais',
            'menu_label' => 'Projetos Comerciais',
            'headline' => 'Projetos comerciais que comunicam valor desde o primeiro olhar.',
            'summary' => 'Mobiliário sob medida para operações mais organizadas e experiências de marca mais fortes.',
            'description' => 'Desenvolvemos ambientes comerciais com foco em operação, atendimento, circulação e posicionamento visual da marca.',
            'image' => 'assets/portfolio-4.jpg',
            'secondary_image' => 'assets/portfolio-1.jpg',
            'pillars' => ['Marca', 'Eficiência', 'Experiência'],
        ],
    ],
];

function is_assoc_array(array $value): bool
{
    return array_keys($value) !== range(0, count($value) - 1);
}

function merge_site_data(array $base, array $override): array
{
    foreach ($override as $key => $value) {
        if (
            isset($base[$key]) &&
            is_array($base[$key]) &&
            is_array($value) &&
            is_assoc_array($base[$key]) &&
            is_assoc_array($value)
        ) {
            $base[$key] = merge_site_data($base[$key], $value);
            continue;
        }

        $base[$key] = $value;
    }

    return $base;
}

$siteDataPath = __DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'site-content.json';
if (is_file($siteDataPath)) {
    $customDataRaw = file_get_contents($siteDataPath);
    if (is_string($customDataRaw) && $customDataRaw !== '') {
        $customData = json_decode($customDataRaw, true);
        if (is_array($customData)) {
            $site = merge_site_data($site, $customData);
        }
    }
}

function environment_url(array $environment): string
{
    return 'ambiente.php?slug=' . urlencode($environment['slug']);
}

function find_environment(array $site, string $slug): ?array
{
    foreach ($site['environments'] as $environment) {
        if ($environment['slug'] === $slug) {
            return $environment;
        }
    }

    return null;
}

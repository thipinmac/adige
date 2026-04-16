(function () {
    const menuToggle = document.querySelector('.menu-toggle');
    const navMenu = document.querySelector('.nav-menu');
    const navLinks = document.querySelectorAll('.nav-menu a');
    const revealNodes = document.querySelectorAll('[data-reveal]');
    const testimonialCards = document.querySelectorAll('[data-testimonial]');
    const testimonialDots = document.querySelectorAll('[data-dot]');
    const leadForms = document.querySelectorAll('.lead-form');
    const environmentJump = document.querySelector('[data-env-jump]');

    if (menuToggle && navMenu) {
        menuToggle.addEventListener('click', () => {
            const isOpen = navMenu.classList.toggle('is-open');
            menuToggle.classList.toggle('is-open', isOpen);
            menuToggle.setAttribute('aria-expanded', String(isOpen));
        });

        navLinks.forEach((link) => {
            link.addEventListener('click', () => {
                navMenu.classList.remove('is-open');
                menuToggle.classList.remove('is-open');
                menuToggle.setAttribute('aria-expanded', 'false');
            });
        });
    }

    if (revealNodes.length) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.18 });

        revealNodes.forEach((node) => observer.observe(node));
    }

    function setActiveTestimonial(index) {
        testimonialCards.forEach((card) => {
            card.classList.toggle('is-active', Number(card.dataset.testimonial) === index);
        });

        testimonialDots.forEach((dot) => {
            dot.classList.toggle('is-active', Number(dot.dataset.dot) === index);
        });
    }

    if (testimonialCards.length && testimonialDots.length) {
        let current = 0;

        testimonialDots.forEach((dot) => {
            dot.addEventListener('click', () => {
                current = Number(dot.dataset.dot);
                setActiveTestimonial(current);
            });
        });

        window.setInterval(() => {
            current = (current + 1) % testimonialCards.length;
            setActiveTestimonial(current);
        }, 5000);
    }

    if (environmentJump) {
        environmentJump.addEventListener('change', () => {
            const target = environmentJump.value.trim();
            if (target !== '') {
                window.location.href = target;
            }
        });
    }

    leadForms.forEach((form) => {
        const statusBox = form.querySelector('.form-success');

        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            if (!statusBox) {
                form.submit();
                return;
            }

            const formData = new FormData(form);
            formData.append('page', window.location.href);

            statusBox.classList.remove('is-visible', 'is-error');
            statusBox.textContent = 'Enviando sua solicitação...';
            statusBox.classList.add('is-visible');

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'fetch',
                    },
                });

                const payload = await response.json();
                if (!response.ok || !payload.ok) {
                    throw new Error(payload.error || 'Não foi possível enviar seu contato agora.');
                }

                const delivery = payload.delivery || {};
                const note = [];

                if (delivery.email) {
                    note.push('e-mail enviado');
                }
                if (delivery.crm) {
                    note.push('CRM atualizado');
                }

                statusBox.textContent = note.length
                    ? 'Solicitação enviada com sucesso: ' + note.join(' e ') + '.'
                    : payload.message;
                form.reset();
            } catch (error) {
                statusBox.classList.add('is-error');
                statusBox.textContent = error instanceof Error
                    ? error.message
                    : 'Falha ao enviar o formulário.';
            }
        });
    });
})();

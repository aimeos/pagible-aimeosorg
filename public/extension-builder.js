/**
 * @license MIT, https://opensource.org/license/MIT
 */

document.querySelectorAll('.extension-builder').forEach(builder => {
    const button = builder.querySelector('.createext');
    const details = builder.querySelector('.extension-builder-details');
    const name = builder.querySelector('input[name="name"]');
    const type = builder.querySelector('select[name="type"]');

    button?.addEventListener('click', () => {
        details.hidden = false;
        button.hidden = true;
        button.setAttribute('aria-expanded', 'true');
        name?.focus();
    });

    const updatePattern = () => {
        if(!name || !type) {
            return;
        }

        const typo3 = type.value.startsWith('typo3-');
        name.pattern = typo3 ? '[a-z0-9]+(?:_[a-z0-9]+)*' : '[a-z0-9]+(?:-[a-z0-9]+)*';
        name.title = typo3
            ? 'Use lowercase letters, numbers and single underscores between words.'
            : 'Use lowercase letters, numbers and single dashes between words.';
    };

    type?.addEventListener('change', updatePattern);
    updatePattern();
});

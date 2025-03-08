document.addEventListener('DOMContentLoaded', function () {
    const openModalBtn = document.getElementById('open-modal');
    const closeModalBtns = document.querySelectorAll('#close-modal');
    const modal = document.getElementById('game-modal');
    const form = document.getElementById('add-game-form');
    const modalTitle = document.getElementById('modal-title');
    const addGameForm = document.getElementById('add-game-form');

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const notification = document.getElementById('notification');
    const notificationMessage = document.getElementById('notification-message');

    function getCSRFToken() {
        return csrfToken;
    }

    const lazyLoadImages = document.querySelectorAll('img[data-src]');
    lazyLoadImages.forEach(img => {
        img.src = img.dataset.src;
    });

    function setBackgroundImage(element) {
        const backgroundImage = element.getAttribute('data-background');
        const mainContainer = document.getElementById('main-container');
        mainContainer.style.backgroundImage = `url('${backgroundImage}')`;
        mainContainer.style.transition = 'background-image 0.5s ease-in-out';
    }

    function filterGamesByPlatform(element) {
        setBackgroundImage(element);

        const selectedPlatform = element.getAttribute('data-platform');
        const allPlatformItems = document.querySelectorAll('li[data-platform]');
        const gameItems = document.querySelectorAll('.game-item');

        allPlatformItems.forEach(item => {
            item.classList.remove('bg-gray-500', 'border-blue-500', 'text-white');
        });

        element.classList.add('bg-gray-500', 'border-blue-500', 'text-white');

        gameItems.forEach(game => {
            const gamePlatform = game.getAttribute('data-platform');
            game.classList.toggle('hidden', selectedPlatform && gamePlatform !== selectedPlatform);
        });
    }

    async function removeGame(button) {
        const gameId = button.getAttribute('data-id');
        const gameItem = button.closest('.game-item');

        try {
            const response = await fetch(`/games/${gameId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            });

            if (!response.ok) throw new Error('Failed to delete game');
            gameItem.remove();
            showNotification('Game removed successfully!', 'success');
        } catch (error) {
            console.error('Error deleting game:', error);
            showNotification('Error deleting game. Try again.', 'error');
        }
    }

    function previewImage(inputId, previewId) {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);

        input.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                preview.classList.add('hidden');
            }
        });
    }

    function showNotification(message, type) {
        notificationMessage.textContent = message;
        notification.classList.remove('hidden', 'bg-green-500', 'bg-red-500');
        notification.classList.add(type === 'success' ? 'bg-green-500' : 'bg-red-500');
        setTimeout(() => notification.classList.add('hidden'), 5000);
    }

    function toggleModal(modal) {
        modal.classList.toggle('hidden');
        modal.classList.toggle('flex');
    }

    async function handleFormSubmission(form, actionUrl, method = 'POST') {
        const formData = new FormData(form);
        try {
            const response = await fetch(actionUrl, {
                method,
                body: formData,
                headers: { 'X-CSRF-TOKEN': getCSRFToken() }
            });

            if (!response.ok) throw new Error('Form submission failed');

            const data = await response.json();
            showNotification(data.message || 'Game Added', 'success');
            toggleModal(document.getElementById('game-modal'), form);
        } catch (error) {
            console.error('Error submitting form:', error);
            showNotification('Error processing request. Try again.', 'error');
        }
    }

    openModalBtn.addEventListener('click', () => {
        modalTitle.textContent = 'Add a New Game';
        form.action = '/store';
        toggleModal(modal, form);
    });

    closeModalBtns.forEach(button => {
        button.addEventListener('click', () => toggleModal(modal));
    });

    form.addEventListener('submit', (event) => {
        event.preventDefault();
        handleFormSubmission(form, form.action);
    });

    // Edit button functionality
    document.querySelectorAll('.edit-game-btn').forEach(button => {
        button.addEventListener('click', async function () {
            const gameId = button.dataset.gameId;
            try {
                const response = await fetch(`/games/${gameId}`);
                const game = await response.json();
                form.title.value = game.title;
                form.console_id.value = game.console_id;
                form.genre_id.value = game.genre_id;
                form.cover.value = game.cover_url;
                modalTitle.textContent = 'Edit Game';
                form.action = `/games/${gameId}`;
                toggleModal(modal);
            } catch (error) {
                console.error('Error loading game details:', error);
            }
        });
    });

    previewImage('game-cover', 'game-cover-preview');
    previewImage('game-additional-cover', 'game-additional-cover-preview');

    // New genre handling
    const addNewGenreBtn = document.getElementById('add-new-genre-btn');
    const addGenreModal = document.getElementById('add-genre-modal');
    const closeModalBtn = document.getElementById('close-modal-btn');
    const newGenreForm = document.getElementById('new-genre-form');

    addNewGenreBtn.addEventListener('click', () => addGenreModal.classList.remove('hidden'));
    closeModalBtn.addEventListener('click', () => addGenreModal.classList.add('hidden'));

    newGenreForm?.addEventListener('submit', async function (event) {
        event.preventDefault();
        const formData = new FormData(newGenreForm);
        try {
            const response = await fetch('genres/store', { method: 'POST', body: formData });
            const data = await response.json();
            if (data.success) {
                const newOption = document.createElement('option');
                newOption.value = data.genre.id;
                newOption.textContent = data.genre.name;
                document.getElementById('genre_id').appendChild(newOption);
                addGenreModal.classList.add('hidden');
            } else {
                alert('Error adding genre.');
            }
        } catch (error) {
            console.error('Error:', error);
        }
    });

    document.querySelectorAll('.remove-game-btn').forEach(button => {
        button.addEventListener('click', () => {
            removeGame(button);
        });
    });
});

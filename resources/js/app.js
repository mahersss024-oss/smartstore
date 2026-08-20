document.addEventListener('livewire:initialized', function () {
    Livewire.on('open-new-tab', url => {
        window.open(url, '_blank');
    });
})

require("./bootstrap");

require("alpinejs");

Livewire.on("confirmDeletePacket", (packetId) => {
    if (confirm("Apakah anda yakin ingin menghapus data ini?")) {
        Livewire.emit("deletePacket", packetId);
    }
});

Livewire.on("confirmStatus", (trxId, status) => {
    if (confirm("Apakah anda yakin ingin mengubah status ini?")) {
        Livewire.emit("updateStatus", trxId, status);
    }
});

Livewire.on("confirmDeleteTicket", (ticketId) => {
    if (confirm("Apakah anda yakin ingin menghapus data ini?")) {
        Livewire.emit("deleteTicket", ticketId);
    }
});

document.addEventListener("livewire:load", () => {
    window.livewire.on("redirect", (url) => Turbolinks.visit(url));
});

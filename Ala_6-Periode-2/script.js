document.addEventListener("DOMContentLoaded", function () {
    const unreadList = document.getElementById("unreadList");
    const readList = document.getElementById("readList");

    // Fetch messages from the server (replace with your server endpoint)
    // This assumes you have an API endpoint to get messages in JSON format
    fetch("api/get_messages.php")
        .then(response => response.json())
        .then(messages => {
            messages.forEach(message => {
                const li = document.createElement("li");
                li.textContent = `${message.contact_Naam} ${message.contact_Achternaam}: ${message.contact_Bericht}`;

                li.addEventListener("click", function () {
                    // Update message status (replace with your server endpoint)
                    // This assumes you have an API endpoint to update message status
                    fetch(`api/update_status.php?id=${message.contact_id}&status=Read`, { method: "POST" })
                        .then(response => response.json())
                        .then(updatedMessage => {
                            li.remove(); // Remove from unread list
                            const newLi = document.createElement("li");
                            newLi.textContent = `${updatedMessage.contact_Naam} ${updatedMessage.contact_Achternaam}: ${updatedMessage.contact_Bericht}`;
                            readList.appendChild(newLi); // Add to read list
                        })
                        .catch(error => console.error("Error updating message status:", error));
                });

                if (message.contact_Status === "Not Read") {
                    unreadList.appendChild(li);
                } else {
                    readList.appendChild(li);
                }
            });
        })
        .catch(error => console.error("Error fetching messages:", error));
});

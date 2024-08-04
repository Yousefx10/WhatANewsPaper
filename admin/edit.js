
    //THE EDIT FUNCTION AREA
        function toggleEdit(articleId) {
            const article = document.querySelector(`.div_article[data-postid="${articleId}"]`);

console.log(article);

            const titleDiv = article.querySelector('.news_title');
            const contentDiv = article.querySelector('.news_content');

            const titleEdit = article.querySelector('.title-edit');
            const contentEdit = article.querySelector('.content-edit');
            const saveButton = article.querySelector('.save-button');

            if (titleEdit.classList.contains('textarea-hidden')) {
                // Switch to edit mode
                titleEdit.value = titleDiv.textContent;
                contentEdit.value = contentDiv.textContent;
                titleEdit.classList.remove('textarea-hidden');
                contentEdit.classList.remove('textarea-hidden');
                saveButton.classList.remove('textarea-hidden');
                titleDiv.classList.add('textarea-hidden');
                contentDiv.classList.add('textarea-hidden');
            } else {
                // Switch to view mode
                titleDiv.textContent = titleEdit.value;
                contentDiv.textContent = contentEdit.value;
                titleEdit.classList.add('textarea-hidden');
                contentEdit.classList.add('textarea-hidden');
                saveButton.classList.add('textarea-hidden');
                titleDiv.classList.remove('textarea-hidden');
                contentDiv.classList.remove('textarea-hidden');
            }
        }

        function saveChanges(articleId) {
            // Call toggleEdit to switch to view mode and save changes
            toggleEdit();

            // Here you would typically send the updated content to the server
            // For example, using fetch or XMLHttpRequest to update the database






            const article = document.querySelector(`.div_article[data-postid="${articleId}"]`);
            const updatedTitle = article.querySelector('.news_title').value;
            const updatedContent = article.querySelector('.news_content').value;

            // Send updated data to the server
            fetch('dashboard.php', { // Replace with your server endpoint
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    id: articleId,
                    title: updatedTitle,
                    content: updatedContent,
                }),
            })
            .then(response => response.json())
            .then(data => {
                console.log('Success:', data);
            })
            .catch((error) => {
                console.error('Error:', error);
            });









        }

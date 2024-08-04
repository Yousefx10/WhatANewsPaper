
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
            console.log(articleId);
            toggleEdit(articleId);

            // Here you would typically send the updated content to the server
            // For example, using fetch or XMLHttpRequest to update the database






            const article = document.querySelector(`.div_article[data-postid="${articleId}"]`);
            const updatedTitle = article.querySelector('.title-edit').value;
            const updatedContent = article.querySelector('.content-edit').value;



            fetch('dashboard.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `edit_id=${encodeURIComponent(articleId)}&edit_title=${encodeURIComponent(updatedTitle)}&edit_content=${encodeURIComponent(updatedContent)}`
            })
            .then(response => response.text())
            .then(data => {
            //    alert(data); // Show the response from the server
                console.log(data);

            })
            .catch(error => {
                console.error('Error:', error);
            });






        }

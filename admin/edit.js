
    //THE EDIT FUNCTION AREA
        function toggleEdit(articleId, currentEDITbtn) {
            const article = document.querySelector(`.div_article[data-postid="${articleId}"]`);
            
            //console.log(article);

            const titleDiv = article.querySelector('.news_title');
            const contentDiv = article.querySelector('.news_content');

            const titleEdit = article.querySelector('.title-edit');
            const contentEdit = article.querySelector('.content-edit');
            const breaking_checkbox = article.querySelector('.breaking-edit');
            const updated_breaking_span = article.querySelector('.categorySPAN');
            
            
            const update_category = article.querySelector('.edit_category');
            const update_category_label = article.querySelector('.edit_category_label');


            const saveButton = article.querySelector('.save-button');

                //console.log(updated_breaking_span);

            if (titleEdit.classList.contains('textarea-hidden')) {
                // Switch to edit mode

                currentEDITbtn.innerHTML="[Cancel Editing)";

                titleEdit.value = titleDiv.textContent;
                contentEdit.value = contentDiv.textContent;
                titleEdit.classList.remove('textarea-hidden');
                contentEdit.classList.remove('textarea-hidden');

                breaking_checkbox.parentElement.classList.remove('textarea-hidden');
                update_category.classList.remove('textarea-hidden');
                update_category_label.classList.remove('textarea-hidden');

                saveButton.classList.remove('textarea-hidden');
                titleDiv.classList.add('textarea-hidden');
                contentDiv.classList.add('textarea-hidden');


                updated_breaking_span.classList.add('textarea-hidden');
            } else {
                // Switch to view mode

                currentEDITbtn.innerHTML="[Edit]";

                titleDiv.textContent = titleEdit.value;
                contentDiv.textContent = contentEdit.value;
                titleEdit.classList.add('textarea-hidden');
                contentEdit.classList.add('textarea-hidden');

                breaking_checkbox.parentElement.classList.add('textarea-hidden');
                updated_breaking_span.classList.remove('so');//remove this prefix

                update_category.classList.add('textarea-hidden');
                update_category_label.classList.add('textarea-hidden');

                updated_breaking_span.innerHTML=update_category.value;


                if(breaking_checkbox.checked)
                updated_breaking_span.classList.add('sobreaking');
                else
                updated_breaking_span.classList.remove('sobreaking');
                
                updated_breaking_span.classList.remove('textarea-hidden');

                saveButton.classList.add('textarea-hidden');
                titleDiv.classList.remove('textarea-hidden');
                contentDiv.classList.remove('textarea-hidden');

            }
        }

        function saveChanges(articleId) {
            // Call toggleEdit to switch to view mode and save changes
            //console.log(articleId); //stop the console log check status
            toggleEdit(articleId);

            // Here you would typically send the updated content to the server
            // For example, using fetch or XMLHttpRequest to update the database






            const article = document.querySelector(`.div_article[data-postid="${articleId}"]`);
            const updatedTitle = article.querySelector('.title-edit').value;
            const updatedContent = article.querySelector('.content-edit').value;
            const breaking_checkbox = article.querySelector('.breaking-edit').checked;
            
            
            const UPDATEDcategory = article.querySelector('.edit_category').value;
            //console.log(breaking_checkbox);


            fetch('dashboard.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `edit_id=${encodeURIComponent(articleId)}&edit_title=${encodeURIComponent(updatedTitle)}&edit_content=${encodeURIComponent(updatedContent)}&edit_breaking=${encodeURIComponent(breaking_checkbox)}&UPDATEDcategory=${encodeURIComponent(UPDATEDcategory)}`
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


        //calling the php function to update the current news articles on dashboard
        function updateCURRENTarticles() {

            fetch('dashboard.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `testonly=${encodeURIComponent("hello")}`
            })
            .then(response => response.json())
            .then(data => {
              //console.log(data.message);
              //console.log("did you see the new result");
              document.getElementById('page2b').innerHTML = data.message;

            })
           //.catch(error => console.error('Error:', error));
        }
        //updateCURRENTarticles();

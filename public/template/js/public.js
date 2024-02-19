$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

function loadMore() {
    const page = $("#page").val();
    $.ajax({
        type: "POST",
        dataType: "JSON",
        data: { page },
        url: "/services/load-product",
        success: function (result) {
            if (result.html !== "") {
                $("#loadProduct").append(result.html);
                $("#page").val(page + 1);
            } else {
                alert("Đã load xong Sản Phẩm");
                $("#button-loadMore").css("display", "none");
            }
        },
    });
}
$(document).ready(function () {
    console.log("document is ready");
    let route = $("#root-route").data("route");
    let dataResponse; // Declare dataResponse here

    fetch(route)
        .then((response) => response.json())
        .then((responseData) => {
            // Assign the data to dataResponse here
            dataResponse = responseData;
            console.log("Data received:", dataResponse);
        })
        .catch((error) => {
            console.error("Error fetching data:", error);
        });

    let search = $("#search-input");
    let typingTimer;
    let doneTypingInterval = 1000; // Time to wait after user stops typing, in milliseconds

    // When the user types in the search input
    search.on("input", () => {
        // Clear the timer if it exists
        clearTimeout(typingTimer);

        // Start a new timer
        typingTimer = setTimeout(() => {
            let searchValue = search.val();
            let matchingName = [];
            let count = 0;
            $("#matching-name-select").remove();
            dataResponse.forEach((item) => {
                if (count >= 5) {
                    return;
                }
                if (item.name.toLowerCase().includes(searchValue.toLowerCase())) {
                    matchingName.push(item.name);
                    count++;
                }
            });
            
            // Create a new <select> element
            let selectElement = $("<ul>");
            // Add options to the <select> element
            matchingName.forEach((name,id) => {
                let optionElement = $("<li>");
                let aElement = $("<a>").text(name);
                aElement.attr("href",'/san-pham/' + (id + 1) + '-' + convertToSlug(name) + '.html');
                aElement.css({
                    'color': 'black'
                });
                optionElement.append(aElement);
                optionElement.attr("value", name);
                selectElement.append(optionElement);
            });

            // Set the id for the <select> element
            selectElement.attr("id", "matching-name-select");
            // Set the name for the <select> element
            selectElement.attr("name", "matching-name");
            // Add the <select> element to the DOM
            $('#select-search').css({
                'background-color': 'white',
            });
            $("#select-search").append(selectElement);
        }, doneTypingInterval);
    });
});
//convertToSlug
function convertToSlug(slug) {
     // Convert to lowercase
     slug = slug.toLowerCase();

     // Replace accented characters
     slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
     slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
     slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
     slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
     slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
     slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
     slug = slug.replace(/đ/gi, 'd');
 
     // Remove special characters
     slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
 
     // Replace spaces with hyphens
     slug = slug.replace(/ /gi, "-");
 
     // Replace multiple hyphens with a single hyphen
     slug = slug.replace(/\-\-\-\-\-/gi, '-');
     slug = slug.replace(/\-\-\-\-/gi, '-');
     slug = slug.replace(/\-\-\-/gi, '-');
     slug = slug.replace(/\-\-/gi, '-');
 
     // Remove hyphens at the start and end
     slug = '@' + slug + '@';
     slug = slug.replace(/\@\-|\-\@|\@/gi, '');
 
     return slug;
}
// select-search css
$(document).ready(function() {
    $('#select-search').css({
        'position': 'relative',
        'display': 'inline-block'
    });

    $('#select-search ul').css({
        'display': 'none',
        'position': 'absolute',
        'background-color': '#f9f9f9',
        'min-width': '160px',
        'box-shadow': '0px 8px 16px 0px rgba(0,0,0,0.2)',
        'padding': '12px 16px',
        'z-index': '1'
    });

    $('#select-search ul li a').css({
        'color': 'black',
        'padding': '12px 16px',
        'text-decoration': 'none',
        'display': 'block'
    });
});
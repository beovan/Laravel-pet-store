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
            
            $("#matching-name-select").remove();
            // Make sure dataResponse is not undefined
            dataResponse.data.forEach((item) => {
                if (
                    item.name.toLowerCase().includes(searchValue.toLowerCase())
                ) {
                    matchingName.push(item.name);
                }
            });
            
            // Create a new <select> element
            let selectElement = $("<ul>");
            let productId = "{{ $product->id }}";
            let productName = "{{ Str::slug($product->name, '-') }}";
            let href = '/san-pham/' + productId + '-' + productName + '.html';
            
            
            // Add options to the <select> element
            matchingName.forEach((name,id) => {
                let optionElement = $("<li>");
                let aElement = $("<a>").text(name);
                aElement.attr("href",'/san-pham/' + (id + 1) + '-' + convertToSlug(name) + '.html');
                console.log(convertToSlug(name));
                optionElement.append(aElement);
                optionElement.attr("value", name);
                selectElement.append(optionElement);
            });

            console.log(matchingName);
            // Set the id for the <select> element
            selectElement.attr("id", "matching-name-select");
            // Set the name for the <select> element
            selectElement.attr("name", "matching-name");
            // Add the <select> element to the DOM
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
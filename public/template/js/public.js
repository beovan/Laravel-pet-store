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
// search
let route = $("#root-route").data("route");
console.log(route);
console.log("hello");

fetch(route)
    .then((response) => response.json())
    .then((responseData) => {
        // Gán dữ liệu lấy được từ API cho biến data
        data = responseData;

        // Kiểm tra xem dữ liệu đã được gán thành công
        console.log("Data received:", data);

        // Gọi hàm hoặc thực hiện các hành động khác với dữ liệu ở đây
    })
    .catch((error) => {
        console.error("Error fetching data:", error);
    });
// const dataResponse = fetchData();
// console.log(dataResponse);
let search = $("#search-input");
let typingTimer;
let doneTypingInterval = 1000; // Thời gian chờ sau khi ngừng nhập, tính bằng mili giây

// Khi người dùng nhập vào ô tìm kiếm
search.on("input", () => {
    // Xóa bộ đếm thời gian nếu có
    clearTimeout(typingTimer);

    // Bắt đầu bộ đếm thời gian mới
    typingTimer = setTimeout(() => {
        let searchValue = search.val();
        let matchingEmails = [];
        dataResponse.forEach((item) => {
            if (item.email.toLowerCase().includes(searchValue.toLowerCase())) {
                matchingEmails.push(item.email);
            }
        });

        // Tạo một phần tử <select> mới
        let selectElement = $("<ul>");

        // Thêm tùy chọn vào phần tử <select>
        matchingEmails.forEach((email) => {
            let optionElement = $("<li>");
            let aElement = $("<a>").text(email);
            aElement.attr("href", route + "/product/search/" + email);
            optionElement.append(aElement);
            optionElement.attr("value", email);
            selectElement.append(optionElement);
        });

        // Đặt id cho phần tử <select>
        selectElement.attr("id", "matching-emails-select");

        // Đặt tên cho phần tử <select>
        selectElement.attr("name", "matching-emails");
        console.log(selectElement);
        // Đưa phần tử <select> vào DOM
        $("#select-search").append(selectElement);
    }, doneTypingInterval);
});




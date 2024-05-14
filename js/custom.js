function alert(title, content, type = "green", width = "small") {
  $.alert({
    title,
    content,
    type,
    columnClass: width,
  });
}

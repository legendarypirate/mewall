class UnbordingContent {
  String image;
  String title;
  String discription;

  UnbordingContent(
      {required this.image, required this.title, required this.discription});
}

List<UnbordingContent> contents = [
  UnbordingContent(
      title: 'Quality Food',
      image: 'assets/b1.png',
      discription:
          // "Uplink нь танд тулгарсан бүх асуудлыг шийдвэрлэх боломжтой юм"
          "Өдөр бүр хэрэгтэй \n мэдээлэл"),
  UnbordingContent(
      title: 'Fast Delevery',
      image: 'assets/b2.png',
      discription:
          // "Uplink нь танд тулгарсан бүх асуудлыг шийдвэрлэх боломжтой юм"
          "Wallpaperе-аа солиод орлоготой бол"),
  UnbordingContent(
      title: 'Reward surprises',
      image: 'assets/b3.png',
      discription:
          // "Uplink нь танд тулгарсан бүх асуудлыг шийдвэрлэх боломжтой юм"
          "Сар бүр пассив орлоготой болох боломж"),
];

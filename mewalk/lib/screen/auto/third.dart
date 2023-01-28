import 'dart:math';

// import 'package:bogdzonhov/mainscreen.dart';
// import 'package:bogdzonhov/network/api.dart';
import 'package:flutter/material.dart';
import 'package:mewalk/screen/login/login.dart';
// import 'package:ipay/screen/register.dart';

class Third extends StatefulWidget {
  // LoginScreen({Key? key}) : super(key: key);

  @override
  State<Third> createState() => _ThirdState();
}

class _ThirdState extends State<Third> {
  bool _passwordVisible = false;
  TextEditingController namecont = TextEditingController();
  bool _checkBox = false;
  bool isChecked = false;
  bool isChecked1 = false;

  bool isChecked2 = false;

  bool isChecked3 = false;

  @override
  Widget build(BuildContext context) {
    Color getColor(Set<MaterialState> states) {
      const Set<MaterialState> interactiveStates = <MaterialState>{
        MaterialState.pressed,
        MaterialState.hovered,
        MaterialState.focused,
      };
      if (states.any(interactiveStates.contains)) {
        return Colors.blue;
      }
      return Colors.red;
    }

    return Scaffold(
      appBar: AppBar(
        titleSpacing: 0.0,
        backgroundColor: Colors.white,
        bottomOpacity: 0.0,
        leading: IconButton(
          icon: Icon(Icons.arrow_back, color: Colors.black),
          onPressed: () => Navigator.of(context).pop(),
        ),
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.vertical(
            bottom: Radius.circular(13),
          ),
        ),
        elevation: 0.0,
        automaticallyImplyLeading: false,
        centerTitle: true,
        actions: <Widget>[
          Row(
            children: <Widget>[],
          )
        ],
      ),
      resizeToAvoidBottomInset: false,
      backgroundColor: Colors.white,
      body: _getBody(),
    );
  }

  TextEditingController passcont = TextEditingController();

  final _formKey = GlobalKey<FormState>();

  Widget _getBody() {
    double totalHeight = MediaQuery.of(context).size.height;
    double totalWidth = MediaQuery.of(context).size.width;
    bool checkedBox = false;
    return Form(
        key: _formKey,
        child: Stack(children: <Widget>[
          Column(
            children: <Widget>[
              Container(
                width: 200,
                margin: EdgeInsets.only(left: 20, right: 20, top: 60),
                child: Image.asset(
                  'assets/cd.png',
                ),
              ),
              Container(
                  margin:
                      EdgeInsets.only(left: 20, right: 20, top: 20, bottom: 20),
                  child: Center(
                    child: Text(
                      'Автоматаар Wallpaper солих тохиргоог асааж өдөр бүр хэрэгтэй мэдээлэл-г wallpaper болгон пассив орлого олоорой.',
                      style: TextStyle(
                        fontSize: 15,
                      ),
                    ),
                  )),
              Positioned(
                bottom: MediaQuery.of(context).viewInsets.bottom,
                left: 30,
                right: 30,
                child: Padding(
                  padding: EdgeInsets.only(
                      left: totalWidth * 0.02, bottom: totalHeight * 0.1),
                  child: SizedBox(
                    height: 50,
                    width: totalWidth * 0.8,
                    child: TextButton(
                        onPressed: () {
                          Navigator.push(
                              context,
                              new MaterialPageRoute(
                                  builder: (context) => Login()));
                          // Map<String, dynamic> data = {
                          //   "passcode": otp,
                          //   // "phone_number": widget.phone
                          // };

                          // Network().checkData2(data, "/passcode").then((value) {
                          //   print(value);
                          //   if (value) {
                          //
                          //   } else {
                          //     ScaffoldMessenger.of(context).showSnackBar(
                          //         SnackBar(content: Text('OTP Incorrect')));
                          //   }
                          // });
                        },
                        style: TextButton.styleFrom(
                          backgroundColor: Colors.blue,
                          primary: Colors.white,
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(15.0),
                          ),
                        ),
                        child: Text('АВТО wallpaper тохиргоог асаах')),
                  ),
                ),
              ),
            ],
          ),
        ]));
  }
}

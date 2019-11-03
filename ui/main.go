// Copyright 2014 The gocui Authors. All rights reserved.
// Use of this source code is governed by a BSD-style
// license that can be found in the LICENSE file.

package main

import (
	"github.com/jroimartin/gocui"
	"log"
)

import "./viewLayout";

const _1_COLS int = 1;
const _2_COLS int = 2;
const _3_COLS int = 3;
const _4_COLS int = 4;
const _5_COLS int = 5;
const _6_COLS int = 6;
const _7_COLS int = 7;
const _8_COLS int = 8;
const _9_COLS int = 9;
const _10_COLS int = 10;
const _11_COLS int = 11;
const _12_COLS int = 12;
const _1_ROWS int = 1;
const _2_ROWS int = 2;
const _3_ROWS int = 3;
const _4_ROWS int = 4;
const _5_ROWS int = 5;
const _6_ROWS int = 6;
const _7_ROWS int = 7;
const _8_ROWS int = 8;
const _9_ROWS int = 9;
const _10_ROWS int = 10;
const _11_ROWS int = 11;
const _12_ROWS int = 12;

func layout(g *gocui.Gui) error {
	layoutManager := viewLayout.NewViewLayoutManager(g, _12_COLS, _12_ROWS);

	box := viewLayout.NewBox("main", _12_COLS, _12_ROWS)

	sideLeftBox := box.AddElement(viewLayout.NewBox("side_left", _3_COLS, _12_ROWS));
	box.AddElement(viewLayout.NewBox("map", _6_COLS, _12_ROWS));
	sideRightBox := box.AddElement(viewLayout.NewBox("side_right", _3_COLS, _12_ROWS));

	layoutManager.CreateViewsFromBox(box);

	sideLeftBox.SetBackgroundColor(gocui.ColorBlue)
	sideRightBox.SetBackgroundColor(gocui.ColorBlue)

	return nil
}

func quit(g *gocui.Gui, v *gocui.View) error {
	return gocui.ErrQuit
}

func main() {
	g, err := gocui.NewGui(gocui.OutputNormal)
	if err != nil {
		log.Panicln(err)
	}
	defer g.Close()

	g.SetManagerFunc(layout)

	if err := g.SetKeybinding("", gocui.KeyCtrlC, gocui.ModNone, quit); err != nil {
		log.Panicln(err)
	}

	if err := g.MainLoop(); err != nil && err != gocui.ErrQuit {
		log.Panicln(err)
	}
}
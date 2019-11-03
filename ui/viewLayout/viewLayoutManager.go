package viewLayout

import (
	"github.com/jroimartin/gocui"
)

type viewLayoutManager struct {
	gui *gocui.Gui
	countCols int
	countRows int
	sizeCols int
	sizeRows int
}

func NewViewLayoutManager(g *gocui.Gui, countCols int, countRows int) viewLayoutManager {
	maxX, maxY := g.Size()
	sizeCols := maxX / countCols
	sizeRows := maxY / countRows

	l := viewLayoutManager{
		g,
		countCols,
		countRows,
		sizeCols,
		sizeRows,
	}
	return l
}

func (l viewLayoutManager) GetBox(startX int, startY int, sizeX int, sizeY int) (int, int, int, int) {
	x := startX * l.sizeCols;
	y := startY * l.sizeRows;
	return x, y, (sizeX * l.sizeCols) + x, (sizeY * l.sizeRows) + y
}
func (l viewLayoutManager) CreateView(name string, startX int, startY int, sizeX int, sizeY int) {
	topLeftX, topLeftY, bottomRightX, bottomRightY := l.GetBox(startX, startY, sizeX, sizeY);
	_, err := l.gui.SetView(name, topLeftX, topLeftY, bottomRightX, bottomRightY)
	if (err != nil && err != gocui.ErrUnknownView) {
		println(err.Error())
	}
}

func (l viewLayoutManager) CreateViewsFromBox(b *box)  {
	topLeftX, topLeftY, bottomRightX, bottomRightY := l.GetBox(
		b.GetPositionX(),
		b.GetPositionY(),
		b.GetWidth(),
		b.GetHeight(),
	)

	view, _ := l.gui.SetView(b.GetName(), topLeftX, topLeftY, bottomRightX, bottomRightY)

	view.Title = b.GetName()
	b.SetView(view)

	for _, element := range b.GetElements() {
		l.CreateViewsFromBox(element)
	}
}
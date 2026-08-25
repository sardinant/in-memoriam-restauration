global g, gL, gSp

on aMyEscapeDown
  go(1, "s100")
end

on aMyDroiteDown
  gLocalWinTheGame()
end

on aPrepareMovie
  gSp.addProp(#GAME, new(script("PS_Game")))
end

on aStartMovie
end

on gLocalWinTheGame
  gL.MAILTODEL.append(#FE06)
  gWinTheGame()
  g.TARGETMARKER = "QUIT"
end

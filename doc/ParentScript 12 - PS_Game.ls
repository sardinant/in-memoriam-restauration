property pCounter, pNumImage, pTrack, pSoluce, pListNameSprite, pSquarreActif, pSecondPart, pBlink
global g, gL, gSp

on new me
  me.mInitNew()
  return me
end

on mInitNew me
  pCounter = 70
  pNumImage = 1
  pSoluce = [["Berthold", "Babureck", "Volker", "Reinhart", "Wagner", "Wichman"], [EMPTY, EMPTY, EMPTY, EMPTY, EMPTY, EMPTY]]
  pListNameSprite = []
  pSquarreActif = 0
  pSecondPart = 0
  pBlink = [["02", "03", "13", "12"], ["33", "34", "43", "44"], ["03", "04"], ["35", "45"], ["26", "36", "37"], ["38", "39", "48", "49"]]
end

on mDelAPhoto me, iINTcase
  pCounter = pCounter - 1
  if pCounter = 0 then
    repeat with vSprite in g[#SQUARRELST]
      vSprite.bWhiteFlash()
    end repeat
    pCounter = 70
    pNumImage = pNumImage + 1
    gSp.sound.mMsgSFX(#VALID)
  end if
  if pNumImage < 3 then
    gSp.counter.bUpdate(pCounter)
    gSp.sound.mMsgSFX(#rollover, [#num: iINTcase])
  else
    pSecondPart = 1
    gSp.counter.bHide()
    gSp.PTNUMBERS.bGoToBlend100()
    repeat with vName in pListNameSprite
      vName.bGoToBlend100()
    end repeat
  end if
end

on mGetNumPhoto me, theSprite
  gSp.addProp(#counter, theSprite)
  return pCounter
end

on mAddAName me, pPlace, theName
  pSoluce[2][pPlace] = theName
  repeat with i in pSoluce[2]
    if i = EMPTY then
      exit
    end if
  end repeat
  if pSoluce[2] = pSoluce[1] then
    gSp.HELP.mMsgHelp(#WIN)
  else
    pSoluce[2] = [EMPTY, EMPTY, EMPTY, EMPTY, EMPTY, EMPTY]
    repeat with vName = 80 to 85
      sprite(vName).bLoose()
    end repeat
    gSp.HELP.mMsgHelp(#BADPLACE)
  end if
end

on mDelAName me, pPlace, theName
  pSoluce[2][pPlace] = EMPTY
end

on mBlink me, iINTNum
  repeat with i in pBlink[iINTNum]
    vSymbol = symbol("SQUARRE_" & i)
    gSp[vSymbol].bBlink()
  end repeat
  gSp.sound.mMsgSFX(#PHOTO_ON)
end

on mBlinkOff me, iINTNum
  repeat with i in pBlink[iINTNum]
    vSymbol = symbol("SQUARRE_" & i)
    gSp[vSymbol].bBlinkOff()
  end repeat
  gSp.sound.mMsgSFX(#PHOTO_OFF)
end

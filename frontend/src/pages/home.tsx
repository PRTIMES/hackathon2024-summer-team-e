import { Box, Container, Typography } from '@mui/material'
import Button from '@mui/material/Button'
import type { NextPage } from 'next'
import Link from 'next/link'
import { useState, useEffect } from 'react'
import ArticleCard from '@/components/ArticleCard'
import Loading from '@/components/Loading'
import { ky } from '@/libs/ky'

type ArticleProps = {
  title: string
  summary: string
  company_name: string
  url: string
}

const Index: NextPage = () => {
  const [articles, setArticles] = useState<ArticleProps[]>([])
  const [loading, setLoading] = useState<boolean>(true)
  const [readMoreDisabled, setReadMoreDisabled] = useState<boolean>(false)

  useEffect(() => {
    ky.get('./api/press-release/recommend')
      .then((v) => {
        return v.json<
          {
            title: string
            summary: string
            company_name: string
            url: string
          }[]
        >()
      })
      .then((value) => {
        setLoading(false)
        setArticles(value)
      })
  }, [])

  if (loading) return <Loading />

  return (
    <Box sx={{ backgroundColor: 'white', minHeight: '100vh', p: 4 }}>
      <Typography
        variant="h3"
        component="h1"
        sx={{ textAlign: 'center', mb: 2, color: 'text.primary' }}
      >
        カスタマイズされたプレスリリースを見る
      </Typography>
      <Typography
        variant="body1"
        component="p"
        sx={{ textAlign: 'center', mb: 4, color: 'text.primary' }}
      >
        あなたが気になる記事を見よう
      </Typography>
      <Container maxWidth="md">
        {articles.map((article, id) => (
          <Box key={id} sx={{ mb: 4, bgcolor: 'white' }}>
            <ArticleCard {...article} />
          </Box>
        ))}
        <Box sx={{ display: 'flex', justifyContent: 'center', mt: 4 }}>
          <Button
            variant="contained"
            color="primary"
            disabled={readMoreDisabled}
            onClick={() => {
              setReadMoreDisabled(true)
              ky.get('./api/press-release/recommend')
                .then((v) => {
                  return v.json<
                    {
                      title: string
                      summary: string
                      company_name: string
                      url: string
                    }[]
                  >()
                })
                .then((v) => {
                  setArticles((prevState) => [...prevState, ...v])
                  setReadMoreDisabled(false)
                })
            }}
          >
            もっと見る
          </Button>
        </Box>
      </Container>
    </Box>
  )
}

export default Index
